<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Hanya admin
        if (Auth::user()?->role?->name !== 'admin') {
            abort(403);
        }

        $query = Pembayaran::with([
            'peserta.user',
            'peserta.acara',
            'peserta.kelasLomba',
            'peserta.burung'
        ]);

        // Filter search (nama peserta / nama burung)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peserta', function ($q) use ($search) {
                $q->where('nama_burung', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran)
    {
        if (Auth::user()?->role?->name !== 'admin') {
            abort(403);
        }

        $pembayaran->load([
            'peserta.user',
            'peserta.acara',
            'peserta.kelasLomba.burung',
            'peserta.burung'
        ]);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Verifikasi / Tolak pembayaran
     */
    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        if (Auth::user()?->role?->name !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'status'        => ['required', 'in:diterima,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
        ]);

        $pembayaran->update([
            'status'        => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        // Update status di tabel peserta
        if ($validated['status'] === 'diterima') {
            $pembayaran->peserta->update(['status' => 'lunas']);
        } else {
            $pembayaran->peserta->update(['status' => 'ditolak']);
        }

        $pesan = $validated['status'] === 'diterima'
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran ditolak.';

        return redirect()
            ->route('pembayaran.show', $pembayaran)
            ->with('success', $pesan);
    }
}