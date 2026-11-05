<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class PembayaranController extends Controller
{
    private function hanyaAdmin(): void
    {
        abort_if(Auth::user()?->role?->name !== 'admin', 403, 'Akses ditolak.');
    }
    
    public function index(Request $request)
    {
        $this->hanyaAdmin();
        // Ambil data pendaftaran (peserta) yang dikelompokkan per user + acara
        $query = Peserta::with(['user', 'acara', 'kelasLomba', 'pembayaran'])
            ->select('peserta.*')
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($q) use ($request) {
                // Filter berdasarkan status pembayaran
                if ($request->status === 'belum_bayar') {
                    $q->doesntHave('pembayaran');
                } else {
                    $q->whereHas('pembayaran', function ($p) use ($request) {
                        $p->where('status', $request->status);
                    });
                }
            });

        // Ambil unique per user + acara (ambil salah satu peserta sebagai representasi)
        $pendaftarans = $query
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn ($item) => $item->user_id . '-' . $item->acara_id)
            ->map(function ($group) {
                $first = $group->first();
                $first->jumlah_kelas = $group->count();
                $first->total_harga  = $group->sum('harga');
                $first->daftar_kelas = $group; // opsional, kalau mau dipakai
                return $first;
            })
            ->values();

        // Manual pagination
        $page    = $request->get('page', 1);
        $perPage = 10;
        $pembayarans = new \Illuminate\Pagination\LengthAwarePaginator(
            $pendaftarans->forPage($page, $perPage),
            $pendaftarans->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $this->hanyaAdmin();

        $pembayaran->load(['peserta.user', 'peserta.acara']);

        abort_if(!$pembayaran->peserta, 404);

        // Ambil SEMUA kelas yang didaftar user tersebut di acara yang sama
        $daftarKelas = Peserta::with('kelasLomba')
            ->where('user_id', $pembayaran->peserta->user_id)
            ->where('acara_id', $pembayaran->peserta->acara_id)
            ->orderBy('nomor_gantangan')
            ->get();

        $totalBayar = $daftarKelas->sum('harga');
        $peserta = $pembayaran->peserta;

        return view('pembayaran.show', compact('pembayaran', 'daftarKelas', 'totalBayar', 'peserta'));
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $this->hanyaAdmin();

        $data = $request->validate([
            'status'        => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $berhasil = DB::transaction(function () use ($pembayaran, $data) {
            $p = Pembayaran::with('peserta')->lockForUpdate()->find($pembayaran->getKey());

            if (!$p || $p->status !== 'menunggu' || !$p->peserta) {
                return false;
            }

            $p->update($data);

            Peserta::where('user_id', $p->peserta->user_id)
                ->where('acara_id', $p->peserta->acara_id)
                ->update(['status' => $data['status'] === 'diterima' ? 'lunas' : 'ditolak']);

            return true;
        });

        if (!$berhasil) {
            return back()->with('error', 'Pembayaran sudah diproses.');
        }

        if ($data['status'] === 'diterima') {
            $wa = $this->siapkanWhatsapp($pembayaran->fresh());

            if ($wa) {
                return back()
                    ->with('success', 'Pembayaran berhasil diverifikasi.')
                    ->with($wa); // wa_url, qr_url, nomor_peserta
            }

            return back()
                ->with('success', 'Pembayaran berhasil diverifikasi.')
                ->with('error', 'Peserta belum punya nomor telepon, jadi WhatsApp tidak bisa dibuka.');
        }

        return back()->with('success', 'Pembayaran ditolak.');
    }

    private function siapkanWhatsapp(Pembayaran $pembayaran): ?array
    {
        $pembayaran->load('peserta.user', 'peserta.acara');
        $user = $pembayaran->peserta?->user;

        // 08123... -> 628123...
        $nomor = preg_replace('/\D/', '', $user?->phone ?? '');
        if ($nomor === '') {
            return null;
        }
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        $daftar = Peserta::with('kelasLomba')
            ->where('user_id', $pembayaran->peserta->user_id)
            ->where('acara_id', $pembayaran->peserta->acara_id)
            ->get();

        $total     = $daftar->sum('harga');
        $namaAcara = $pembayaran->peserta->acara?->nama ?? '-';
        $kode      = 'PAY-' . str_pad($pembayaran->id_pembayaran, 5, '0', STR_PAD_LEFT);

        $kelasTeks = $daftar->map(fn($p) =>
            '- ' . ($p->kelasLomba?->nama ?? '-') . ' (No. Gantangan ' . $p->nomor_gantangan . ')'
        )->implode("\n");

        // Isi QR: ganti sesuai kebutuhan scan di lokasi lomba
        $isiQr = "LUNAS\n{$kode}\n{$user->name}\n{$namaAcara}\n" . $kelasTeks;

        $path = "qr/{$kode}.png";

        $hasil = Builder::create()
            ->writer(new PngWriter())
            ->data($isiQr)
            ->size(400)
            ->margin(10)
            ->build();

        Storage::disk('public')->put($path, $hasil->getString());

        $qrUrl = asset('storage/' . $path);

        $pesan = "Halo {$user->name},\n\n"
            . "Pembayaran Anda untuk acara *{$namaAcara}* sudah kami verifikasi (LUNAS).\n\n"
            . "Kelas yang diikuti:\n{$kelasTeks}\n\n"
            . "Total: Rp " . number_format($total, 0, ',', '.') . "\n"
            . "Kode: {$kode}\n\n"
            . "Tunjukkan QR Code berikut saat hadir di lokasi lomba:\n{$qrUrl}\n\n"
            . "Terima kasih.";

        return [
            'wa_url'        => 'https://wa.me/' . $nomor . '?text=' . rawurlencode($pesan),
            'qr_url'        => $qrUrl,
            'nomor_peserta' => $user->phone,
        ];
    }

    public function detail(Peserta $peserta)
    {
        $this->hanyaAdmin();

        // Ambil semua kelas user ini di acara yang sama
        $daftarKelas = Peserta::with(['kelasLomba', 'pembayaran'])
            ->where('user_id', $peserta->user_id)
            ->where('acara_id', $peserta->acara_id)
            ->orderBy('nomor_gantangan')
            ->get();

        $totalBayar = $daftarKelas->sum('harga');

        // Ambil pembayaran jika sudah ada (bisa null)
        $pembayaran = $daftarKelas
            ->first(fn ($p) => $p->pembayaran !== null)
            ?->pembayaran;

        return view('pembayaran.show', compact('pembayaran', 'daftarKelas', 'totalBayar', 'peserta'));
    }
}