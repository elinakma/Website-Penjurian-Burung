<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\Burung;
use App\Models\KelasLomba;
use App\Models\Peserta;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    /**
     * Tampilkan form pendaftaran untuk peserta
     */
    public function create()
    {
        if (Auth::user()?->role?->name !== 'peserta') {
            abort(403, 'Akses ditolak.');
        }

        // Hanya acara yang masih dibuka
        $acaras = Acara::whereIn('status', ['Belum Mulai', 'Berlangsung'])
            ->orderBy('tanggal')
            ->get();

        // Kelas yang statusnya masih pendaftaran + acara masih dibuka
        $kelasLombas = KelasLomba::with(['burung', 'acara'])
            ->where('status', 'pendaftaran')
            ->whereHas('acara', function ($q) {
                $q->whereIn('status', ['Belum Mulai', 'Berlangsung']);
            })
            ->get();

        return view('peserta.daftar', compact('kelasLombas', 'acaras'));
    }

    public function store(Request $request)
    {
        if (Auth::user()?->role?->name !== 'peserta') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'alamat'        => ['required', 'string', 'max:500'],
            'acara_id'      => ['required', 'exists:acaras,id_acara'],
            'kelas_lomba'   => ['required', 'array', 'min:1'],
            'kelas_lomba.*' => ['exists:kelas_lomba,id_kelas'],
        ]);

        $created = [];
        $errors  = [];

        foreach ($validated['kelas_lomba'] as $kelasId) {
            $kelas = KelasLomba::with('acara')->find($kelasId);

            if (!$kelas || $kelas->status !== 'pendaftaran') {
                $errors[] = "Kelas \"{$kelas?->nama}\" sudah ditutup.";
                continue;
            }

            // Pastikan kelas milik acara yang dipilih
            if ($kelas->acara_id != $validated['acara_id']) {
                $errors[] = "Kelas \"{$kelas->nama}\" tidak sesuai dengan acara yang dipilih.";
                continue;
            }

            $terdaftar = Peserta::where('kelas_lomba_id', $kelas->id_kelas)->count();

            if ($terdaftar >= $kelas->kuota) {
                $errors[] = "Kuota kelas \"{$kelas->nama}\" sudah penuh.";
                continue;
            }

            $nomorGantangan = $terdaftar + 1;

            Peserta::create([
                'user_id'         => Auth::id(),
                'kelas_lomba_id'  => $kelas->id_kelas,
                'acara_id'        => $kelas->acara_id,
                'burung_id'       => $kelas->burung_id,          // ambil dari kelas
                'nama_burung'     => Auth::user()->name,         // pakai nama akun
                'alamat'          => $validated['alamat'],
                'harga'           => $kelas->harga,
                'nomor_gantangan' => $nomorGantangan,
                'status'          => 'menunggu_pembayaran',
            ]);

            $created[] = [
                'kelas'  => $kelas->nama,
                'nomor'  => $nomorGantangan,
                'harga'  => $kelas->harga,
            ];
        }

        if (empty($created)) {
            return back()
                ->with('error', 'Tidak ada kelas yang berhasil didaftarkan. ' . implode(' ', $errors))
                ->withInput();
        }

        $pesan = count($created) . ' kelas berhasil didaftarkan:<br>';
        foreach ($created as $c) {
            $pesan .= "• {$c['kelas']} (No. Gantangan: {$c['nomor']}) — Rp " . number_format($c['harga'], 0, ',', '.') . '<br>';
        }

        if (!empty($errors)) {
            $pesan .= '<br><span class="text-red-600">Beberapa kelas gagal: ' . implode(' ', $errors) . '</span>';
        }

        return redirect()
            ->route('peserta.riwayat')
            ->with('success', $pesan);
    }
    /**
     * Riwayat pendaftaran peserta
     */
    public function riwayat()
    {
        $riwayats = Peserta::with(['kelasLomba', 'acara', 'pembayaran'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->groupBy('acara_id');   // 1 acara = 1 card

        return view('peserta.riwayat', compact('riwayats'));
    }

    public function uploadBukti(Request $request, Peserta $peserta)
    {
        abort_if($peserta->user_id !== Auth::id(), 403);

        $request->validate([
            'foto'       => 'required|image|max:2048',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $sudahAda = Pembayaran::whereHas('peserta', fn($q) => $q
            ->where('user_id', $peserta->user_id)
            ->where('acara_id', $peserta->acara_id))
            ->where('status', '!=', 'ditolak')
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Bukti pembayaran untuk acara ini sudah dikirim.');
        }

        $path = $request->file('foto')->store('bukti-pembayaran', 'public');

        DB::transaction(function () use ($peserta, $request, $path) {
            Pembayaran::create([
                'peserta_id' => $peserta->id,
                'foto'       => $path,
                'keterangan' => $request->keterangan,
                'status'     => 'menunggu',
            ]);

            Peserta::where('user_id', $peserta->user_id)
                ->where('acara_id', $peserta->acara_id)
                ->update(['status' => 'menunggu_verifikasi']);
        });

        return back()->with('success', 'Bukti pembayaran berhasil dikirim.');
    }
}