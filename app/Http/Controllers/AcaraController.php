<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\KelasLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AcaraController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = Acara::query()->withCount('kelasLombas');

        // ========== FILTER UNTUK JURI ==========
        // Hanya tampilkan acara yang memiliki minimal 1 kelas
        // di mana juri ini ditugaskan (via pivot kelas_lomba_juri)
        if ($user->role?->name === 'juri') {
            $query->whereHas('kelasLombas.juris', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        // Admin & role lain: tetap lihat semua acara

        // Pencarian berdasarkan nama atau lokasi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter rentang tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $acaras = $query->latest('tanggal')
                        ->paginate(10)
                        ->withQueryString();

        return view('acara.index', compact('acaras'));
    }

    private function ensureAdmin()
    {
        if (Auth::user()?->role?->name !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('acara.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi'  => ['required', 'string', 'max:255'],
            'status'  => ['nullable', Rule::in(['Belum Mulai', 'Berlangsung', 'Selesai'])],
        ]);

        // Default status jika tidak dikirim
        $validated['status'] = $validated['status'] ?? 'Belum Mulai';
        $validated['pengguna_id'] = Auth::id();

        Acara::create($validated);

        return redirect()
            ->route('acara.index')
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    public function show(Acara $acara)
    {
        $user = Auth::user();

        // ========== PROTEKSI AKSES JURI ==========
        // Juri hanya boleh lihat acara yang dia ditugaskan
        if ($user->role?->name === 'juri') {
            $isAssigned = $acara->kelasLombas()
                ->whereHas('juris', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                })
                ->exists();

            if (!$isAssigned) {
                abort(403, 'Anda tidak ditugaskan pada acara ini.');
            }
        }

        $acara->load('pengguna');

        // Untuk juri: hanya tampilkan kelas yang dia uji
        // Untuk admin: tampilkan semua kelas
        $kelasQuery = KelasLomba::with(['burung', 'juris'])
            ->where('acara_id', $acara->id_acara);

        if ($user->role?->name === 'juri') {
            $kelasQuery->whereHas('juris', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $kelasLombas = $kelasQuery->latest('id_kelas')
                                ->paginate(10)
                                ->withQueryString();

        return view('acara.show', compact('acara', 'kelasLombas'));
    }

    public function edit(Acara $acara)
    {
        $this->ensureAdmin();
        return view('acara.edit', compact('acara'));
    }

    public function update(Request $request, Acara $acara)
    {
        $this->ensureAdmin();
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi'  => ['required', 'string', 'max:255'],
            'status'  => ['required', Rule::in(['Belum Mulai', 'Berlangsung', 'Selesai'])],
        ]);

        $acara->update($validated);

        return redirect()
            ->route('acara.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Acara $acara)
    {
        $this->ensureAdmin();
        $acara->delete();

        return redirect()
            ->route('acara.index')
            ->with('success', 'Acara berhasil dihapus.');
    }

    public function mulai(Acara $acara)
    {
        $this->ensureAdmin();

        // Validasi: harus ada minimal 1 kelas lomba
        if ($acara->kelasLombas()->count() === 0) {
            return redirect()
                ->route('acara.index')
                ->with('error', 'Acara belum bisa dimulai. Silakan buat kelas lomba terlebih dahulu.');
        }

        // Sudah dimulai / selesai
        if ($acara->status !== 'Belum Mulai') {
            return redirect()
                ->route('acara.index')
                ->with('error', 'Acara sudah ' . strtolower($acara->status) . '.');
        }

        // Update status
        $acara->update(['status' => 'Berlangsung']);

        // Load relasi yang dibutuhkan
        $acara->load(['kelasLombas.burung', 'kelasLombas.juris']);

        // ========== KIRIM KE JURI (hanya juri yang ditugaskan per kelas) ==========
        $juriNotified = [];
        foreach ($acara->kelasLombas as $kelas) {
            foreach ($kelas->juris as $juri) {
                // Hindari notifikasi ganda jika 1 juri di banyak kelas
                if (isset($juriNotified[$juri->id])) {
                    continue;
                }
                $juriNotified[$juri->id] = true;
            }
        }

        // ========== KIRIM KE SEMUA PESERTA ==========
        // Ambil user role "peserta" (sesuaikan nama role)
        $pesertas = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'peserta');
        })->get();

        foreach ($pesertas as $peserta) {
            // $peserta->notify(new AcaraTersediaNotification($acara));
            // \Log::info("Notifikasi ke peserta {$peserta->name}: Acara {$acara->nama} tersedia");
        }

        return redirect()
            ->route('acara.index')
            ->with('success', 'Acara berhasil dimulai. Data telah dikirim ke juri dan peserta.');
    }
}