<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                {{-- Bagian Kiri: Judul dan Deskripsi --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Pembayaran</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Kelola dan periksa data pembayaran peserta lomba.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Filter --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <form action="{{ route('pembayaran.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- Cari Peserta --}}
                    <div>
                        <label for="search"
                            class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Cari Peserta
                        </label>

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2" d="m16 16 4 4"/>
                            </svg>

                            <input type="text" id="search" name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama peserta..."
                                class="w-full rounded-xl border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                        </div>
                    </div>

                    {{-- Filter Status --}}
                    <div>
                        <label for="status"
                            class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Status Pembayaran
                        </label>

                        <select id="status" name="status"
                            class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                            <option value="">Semua Status</option>
                            <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>
                                Belum Upload Bukti
                            </option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                Menunggu Verifikasi
                            </option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Tombol Filter --}}
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M3 4h18l-7 8v6l-4 2v-8L3 4z"/>
                        </svg>
                        Terapkan Filter
                    </button>

                    <a href="{{ route('pembayaran.index') }}"
                        class="inline-flex items-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel Pembayaran --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="font-bold text-gray-800">Daftar Pembayaran Peserta</h2>
                <p class="text-sm text-gray-500">
                    Total: <span class="font-semibold">{{ $pembayarans->total() }}</span> pembayaran
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left">
                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="w-16 px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">No</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-[#24482f]">Peserta</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-[#24482f]">Burung / Kelas</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-[#24482f]">Total Bayar</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Status</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($pembayarans as $index => $item)
                            @php
                                $bayar = $item->daftar_kelas->pluck('pembayaran')->filter()->first();
                            @endphp
                            <tr class="transition-colors hover:bg-[#f8faf9]">
                                <td class="px-4 py-4 text-center">
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ $pembayarans->firstItem() + $index }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-800">{{ $item->user?->name ?? '-' }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $item->acara?->nama ?? '-' }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $item->nama_burung ?? '-' }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $item->jumlah_kelas }} kelas lomba</p>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-[#527b5d]">
                                        Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if(!$bayar)
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">Belum Bayar</span>
                                    @elseif($bayar->status === 'menunggu')
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                    @elseif($bayar->status === 'diterima')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Diterima</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ $bayar ? route('pembayaran.show', $bayar->id_pembayaran) : route('pembayaran.detail', $item->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#527b5d] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#42684d]">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="7" stroke-width="1.5"/>
                                            <path stroke-linecap="round" stroke-width="1.5" d="m16 16 4 4"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-500">Tidak ada data pendaftaran.</p>
                                        <a href="{{ route('pembayaran.index') }}" class="text-sm font-semibold text-[#527b5d] hover:underline">
                                            Reset filter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pembayarans->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">
                    {{ $pembayarans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>