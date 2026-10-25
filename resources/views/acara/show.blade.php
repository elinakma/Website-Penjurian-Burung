<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Detail Acara</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Informasi lengkap acara dan daftar kelas lomba yang tersedia.
                    </p>
                </div>

                <div class="flex shrink-0">
                    <a href="{{ route('acara.index') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Informasi Acara --}}
        <div class="w-full mx-auto">
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                {{-- Header Card --}}
                <div class="flex flex-col gap-3 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Informasi Acara
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Detail informasi acara yang telah disimpan.
                        </p>
                    </div>
                </div>

                {{-- Detail Data --}}
                <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 sm:p-8">

                    {{-- Nama Acara --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-500">
                            Nama Acara
                        </p>
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="break-words text-base font-bold text-gray-800">
                                    {{ $acara->nama }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-500">
                            Tanggal Acara
                        </p>
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-500">
                            Lokasi Acara
                        </p>
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="break-words text-base font-bold text-gray-800">
                                    {{ $acara->lokasi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-500">
                            Status Acara
                        </p>

                        @php
                            $statusClass = match($acara->status) {
                                'Berlangsung' => 'bg-emerald-100 text-emerald-800',
                                'Belum Mulai' => 'bg-amber-100 text-amber-800',
                                'Selesai' => 'bg-gray-100 text-gray-600',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-bold {{ $statusClass }}">
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                            {{ $acara->status }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Daftar Kelas Lomba --}}
        <div class="w-full mx-auto">
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                {{-- Header Tabel --}}
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <h2 class="text-lg font-bold text-[#0e1e17]">
                            Daftar Kelas Lomba
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Daftar kelas yang terdaftar pada acara ini.
                        </p>
                    </div>

                    <span class="text-sm text-gray-500">
                        {{ $kelasLombas->total() }} kelas terdaftar
                    </span>
                </div>

                {{-- Tabel Kelas Lomba --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] table-fixed divide-y divide-gray-100">
                        <colgroup>
                            <col class="w-[5%]">
                            <col class="w-[18%]">
                            <col class="w-[16%]">
                            <col class="w-[12%]">
                            <col class="w-[9%]">
                            <col class="w-[18%]">
                            <col class="w-[13%]">
                            <col class="w-[9%]">
                        </colgroup>

                        <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                            <tr>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    No
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Nama Kelas <span class="text-red-500">*</span>
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Jenis Burung <span class="text-red-500">*</span>
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Harga (Rp) <span class="text-red-500">*</span>
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Kuota <span class="text-red-500">*</span>
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Juri
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Jadwal Final
                                </th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($kelasLombas as $index => $kelasLomba)
                                <tr class="transition hover:bg-gray-50/80">

                                    {{-- Nomor --}}
                                    <td class="px-3 py-4 text-center text-sm text-gray-500">
                                        {{ $kelasLombas->firstItem() + $index }}
                                    </td>

                                    {{-- Nama Kelas --}}
                                    <td class="break-words px-3 py-4 text-center text-sm">
                                        <p class="font-semibold text-gray-800">
                                            {{ $kelasLomba->nama }}
                                        </p>
                                    </td>

                                    {{-- Jenis Burung --}}
                                    <td class="break-words px-3 py-4 text-center text-sm text-gray-600">
                                        {{ $kelasLomba->burung->nama ?? '-' }}
                                    </td>

                                    {{-- Harga --}}
                                    <td class="px-3 py-4 text-center text-sm font-medium text-gray-700">
                                        Rp{{ number_format($kelasLomba->harga, 0, ',', '.') }}
                                    </td>

                                    {{-- Kuota --}}
                                    <td class="px-3 py-4 text-center text-sm text-gray-600">
                                        {{ number_format($kelasLomba->kuota, 0, ',', '.') }}
                                    </td>

                                    {{-- Juri --}}
                                    <td class="break-words px-3 py-4 text-sm text-gray-600">
                                        @if ($kelasLomba->juris->isNotEmpty())
                                            {{ $kelasLomba->juris->pluck('name')->implode(', ') }}
                                        @else
                                            <span class="text-gray-400">
                                                Belum ada juri
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Jadwal Final --}}
                                    <td class="px-3 py-4 text-center text-sm text-gray-600">
                                        @if ($kelasLomba->final_at)
                                            {{ \Carbon\Carbon::parse($kelasLomba->final_at)->translatedFormat('d M Y, H:i') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-3 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{ route('kelas-lomba.edit', $kelasLomba->id_kelas) }}"
                                                title="Edit kelas"
                                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('kelas-lomba.destroy', $kelasLomba->id_kelas) }}"
                                                method="POST"
                                                class="form-hapus-kelas">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                    title="Hapus kelas"
                                                    class="btn-hapus-kelas inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 7h16M10 11v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3"/>
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-14 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 font-semibold text-gray-800">
                                            Belum Ada Kelas Lomba
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Belum ada kelas lomba yang terdaftar pada acara ini.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kelasLombas->hasPages())
                    <div class="border-t border-gray-100 px-6 py-4 sm:px-8">
                        {{ $kelasLombas->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>