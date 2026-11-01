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

        $burungs = Burung::orderBy('nama')->get();

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

        return view('peserta.daftar', compact('burungs', 'kelasLombas', 'acaras'));
    }

    /**
     * Simpan data peserta
     */
    public function store(Request $request)
    {
        if (Auth::user()?->role?->name !== 'peserta') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'nama_burung'   => ['required', 'string', 'max:255'],
            'alamat'        => ['required', 'string', 'max:500'],
            'acara_id'      => ['required', 'exists:acaras,id_acara'],
            'jenis_burung'  => ['required', 'exists:jenis_burung,id'],
            'kelas_lomba'   => ['required', 'exists:kelas_lomba,id_kelas'],
            'tiket'         => ['required', 'numeric', 'min:0'],
        ]);

        $kelas = KelasLomba::with('acara')->findOrFail($validated['kelas_lomba']);

        // Cek status kelas
        if ($kelas->status !== 'pendaftaran') {
            return back()->with('error', 'Kelas lomba ini sudah ditutup.')->withInput();
        }

        // Hitung jumlah yang sudah terdaftar di kelas ini
        $terdaftar = Peserta::where('kelas_lomba_id', $kelas->id_kelas)->count();

        // Cek kuota
        if ($terdaftar >= $kelas->kuota) {
            return back()->with('error', 'Kuota kelas sudah penuh.')->withInput();
        }

        // Ambil nomor gantangan berikutnya
        $nomorGantangan = $terdaftar + 1;

        // Simpan data peserta
        Peserta::create([
            'user_id'           => Auth::id(),
            'kelas_lomba_id'    => $kelas->id_kelas,
            'acara_id'          => $kelas->acara_id,
            'burung_id'         => $validated['jenis_burung'],
            'nama_burung'       => $validated['nama_burung'],
            'alamat'            => $validated['alamat'],
            'harga'             => $validated['tiket'],
            'nomor_gantangan'   => $nomorGantangan,
            'status'            => 'menunggu_pembayaran',
        ]);

        return redirect()
            ->route('peserta.riwayat')
            ->with('success', "Pendaftaran berhasil! Nomor Gantangan Anda: {$nomorGantangan}");
    }
    /**
     * Riwayat pendaftaran peserta
     */
    public function riwayat()
    {
        if (Auth::user()?->role?->name !== 'peserta') {
            abort(403, 'Akses ditolak.');
        }

        $riwayats = Peserta::with(['kelasLomba.burung', 'acara', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peserta.riwayat', compact('riwayats'));
    }

    public function uploadBukti(Request $request, $id)
    {
        if (Auth::user()?->role?->name !== 'peserta') {
            abort(403);
        }

        $peserta = Peserta::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek apakah sudah ada pembayaran
        if ($peserta->pembayaran) {
            return back()->with('error', 'Bukti pembayaran sudah diupload sebelumnya.');
        }

        $validated = $request->validate([
            'foto'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        // Simpan foto
        $path = $request->file('foto')->store('bukti-pembayaran', 'public');

        Pembayaran::create([
            'peserta_id'  => $peserta->id,
            'foto'        => $path,
            'keterangan'  => $validated['keterangan'] ?? null,
            'status'      => 'menunggu',
        ]);

        // Update status peserta (opsional)
        $peserta->update(['status' => 'menunggu_verifikasi']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}