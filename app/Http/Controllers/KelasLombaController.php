<?php

namespace App\Http\Controllers;

use App\Models\KelasLomba;
use App\Models\Acara;
use App\Models\Burung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasLombaController extends Controller
{
    /**
     * Tampilkan daftar acara (entry point)
     */
    public function index(Request $request)
    {
        $query = Acara::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $acaras = $query->latest('tanggal')
                        ->paginate(10)
                        ->withQueryString();

        return view('kelas-lomba.index', compact('acaras'));
    }

    public function create(Request $request)
    {
        if (!$request->filled('acara_id')) {
            return redirect()
                ->route('kelas-lomba.index')
                ->with('error', 'Silakan pilih acara terlebih dahulu.');
        }

        $acara = Acara::findOrFail($request->acara_id);

        $kelasLombas = KelasLomba::with(['burung', 'juris'])
            ->where('acara_id', $acara->id_acara)
            ->latest('id_kelas')
            ->paginate(10)
            ->withQueryString();

        $burungs = Burung::orderBy('nama')->get();

        // Ambil semua user yang role-nya "juri"
        $juris = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'juri'); // sesuaikan nama role di database
        })->orderBy('name')->get();

        return view('kelas-lomba.create', compact('acara', 'kelasLombas', 'burungs', 'juris'));
    }

    /**
     * Simpan kelas lomba (mendukung single & bulk)
     */
    public function store(Request $request)
    {
        // ========== BULK ==========
        if ($request->has('kelas') && is_array($request->kelas)) {
            $validated = $request->validate([
                'acara_id'              => ['required', 'exists:acaras,id_acara'],
                'kelas'                 => ['required', 'array', 'min:1'],
                'kelas.*.nama'          => ['required', 'string', 'max:255'],
                'kelas.*.harga'         => ['required', 'integer', 'min:0'],
                'kelas.*.kuota'         => ['required', 'integer', 'min:1'],
                'kelas.*.final_at'      => ['nullable', 'date'],
                'kelas.*.burung_id'     => ['required', 'exists:jenis_burung,id'],
                'kelas.*.juri_ids'      => ['nullable', 'array'],
                'kelas.*.juri_ids.*'    => ['exists:users,id'],
            ]);

            $acaraId = $validated['acara_id'];
            $count   = 0;

            foreach ($validated['kelas'] as $data) {
                $kelas = KelasLomba::create([
                    'acara_id'  => $acaraId,
                    'nama'      => $data['nama'],
                    'burung_id' => $data['burung_id'],
                    'harga'     => $data['harga'],
                    'kuota'     => $data['kuota'],
                    'status'    => 'pendaftaran',
                    'final_at'  => $data['final_at'] ?? null,
                ]);

                // Simpan juri (jika ada)
                if (!empty($data['juri_ids'])) {
                    $kelas->juris()->sync($data['juri_ids']);
                }

                $count++;
            }

            return redirect()
                ->route('kelas-lomba.create', ['acara_id' => $acaraId])
                ->with('success', "{$count} kelas lomba berhasil ditambahkan.");
        }

        // ========== SINGLE (jika masih dipakai) ==========
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kuota'     => ['required', 'integer', 'min:1'],
            'final_at'  => ['nullable', 'date'],
            'acara_id'  => ['required', 'exists:acaras,id_acara'],
            'burung_id' => ['required', 'exists:jenis_burung,id'],
        ]);

        $validated['status'] = 'pendaftaran';   // ← otomatis juga

        KelasLomba::create($validated);

        return redirect()
            ->route('kelas-lomba.create', ['acara_id' => $validated['acara_id']])
            ->with('success', 'Kelas lomba berhasil ditambahkan.');
    }

    /**
     * Detail kelas lomba per acara + form bulk tambah
     */
    public function show(Acara $acara)
    {
        $kelasLombas = KelasLomba::with('burung')
            ->where('acara_id', $acara->id_acara)
            ->latest('id_kelas')
            ->paginate(10);

        $burungs = Burung::orderBy('nama')->get();

        return view('kelas-lomba.show', compact('acara', 'kelasLombas', 'burungs'));
    }

    /**
     * Form edit kelas lomba
     */
    public function edit(KelasLomba $kelasLomba)
    {
        $acaras  = Acara::orderBy('nama')->get();
        $burungs = Burung::orderBy('nama')->get();

        return view('kelas-lomba.edit', compact('kelasLomba', 'acaras', 'burungs'));
    }

    /**
     * Update kelas lomba
     */
    public function update(Request $request, KelasLomba $kelasLomba)
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kuota'     => ['required', 'integer', 'min:1'],
            'status'    => ['required', Rule::in(['pendaftaran', 'penilaian', 'selesai'])],
            'final_at'  => ['nullable', 'date'],
            'acara_id'  => ['required', 'exists:acaras,id_acara'],
            'burung_id' => ['required', 'exists:jenis_burung,id'],
        ]);

        $kelasLomba->update($validated);

        return redirect()
            ->route('kelas-lomba.create', ['acara_id' => $validated['acara_id']])
            ->with('success', 'Kelas lomba berhasil diperbarui.');
    }

    /**
     * Hapus kelas lomba
     */
    public function destroy(KelasLomba $kelasLomba)
    {
        $acaraId = $kelasLomba->acara_id;

        $kelasLomba->delete();

        return redirect()
            ->route('kelas-lomba.create', ['acara_id' => $acaraId])
            ->with('success', 'Kelas lomba berhasil dihapus.');
    }
}