<?php

namespace App\Http\Controllers;

use App\Models\Burung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BurungController extends Controller
{
    /**
     * Tampilkan daftar jenis burung
     */
    public function index(Request $request)
    {
        $query = Burung::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        $burungs = $query->latest()
                         ->paginate(10)
                         ->withQueryString();

        return view('burung.index', compact('burungs'));
    }

    /**
     * Form tambah jenis burung
     */
    public function create()
    {
        return view('burung.create');
    }

    /**
     * Simpan jenis burung baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_burung,nama'],
        ]);

        Burung::create($validated);

        return redirect()
            ->route('burung.index')
            ->with('success', 'Jenis burung berhasil ditambahkan.');
    }

    /**
     * Detail jenis burung
     */
    public function show(Burung $burung)
    {
        return view('burung.show', compact('burung'));
    }

    /**
     * Form edit jenis burung
     */
    public function edit(Burung $burung)
    {
        return view('burung.edit', compact('burung'));
    }

    /**
     * Update jenis burung
     */
    public function update(Request $request, Burung $burung)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis_burung', 'nama')->ignore($burung->id),
            ],
        ]);

        $burung->update($validated);

        return redirect()
            ->route('burung.index')
            ->with('success', 'Jenis burung berhasil diperbarui.');
    }

    /**
     * Hapus jenis burung
     */
    public function destroy(Burung $burung)
    {
        $burung->delete();

        return redirect()
            ->route('burung.index')
            ->with('success', 'Jenis burung berhasil dihapus.');
    }
}