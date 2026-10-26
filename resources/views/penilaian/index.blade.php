<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 shadow-sm sm:p-8"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">
                        Penilaian Lomba
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola penilaian dan pantau hasil perlombaan burung.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $kelasLomba = [
            [
                'id' => 1,
                'acara' => 'Lomba Burung Cup 2026',
                'nama' => 'Murai Batu C Kamulyan',
                'tanggal' => '26 Oktober 2026',
                'jumlah_peserta' => 24,
                'jumlah_juri' => 4,
                'status' => 'berlangsung',
            ],
            [
                'id' => 2,
                'acara' => 'Lomba Burung Cup 2026',
                'nama' => 'Murai Batu B Kamulyan',
                'tanggal' => '26 Oktober 2026',
                'jumlah_peserta' => 20,
                'jumlah_juri' => 4,
                'status' => 'pendaftaran',
            ],
            [
                'id' => 3,
                'acara' => 'Latber Burung Minggu',
                'nama' => 'Cucak Hijau A',
                'tanggal' => '25 Oktober 2026',
                'jumlah_peserta' => 18,
                'jumlah_juri' => 4,
                'status' => 'selesai',
            ],
            [
                'id' => 4,
                'acara' => 'Piala Kicau Madiun',
                'nama' => 'Murai Batu A',
                'tanggal' => '24 Oktober 2026',
                'jumlah_peserta' => 22,
                'jumlah_juri' => 4,
                'status' => 'berlangsung',
            ],
        ];
    @endphp

    <div class="space-y-5">

        {{-- Filter --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('penilaian.index') }}"
                class="grid grid-cols-1 items-end gap-4 md:grid-cols-3">

                <div>
                    <label for="search"
                        class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Cari Kelas Lomba
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m16 16 4 4"/>
                        </svg>
                        <input id="search" name="search" type="text"
                            value="{{ request('search') }}"
                            placeholder="Masukkan nama kelas..."
                            class="w-full rounded-xl border-gray-200 py-2.5 pl-9 pr-3 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </div>
                </div>

                <div>
                    <label for="status"
                        class="mb-1.5 block text-sm font-semibold text-gray-700">
                        Status Penilaian
                    </label>
                    <select id="status" name="status"
                        class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                        <option value="">Semua Status</option>
                        <option value="pendaftaran" @selected(request('status') === 'pendaftaran')>
                            Pendaftaran
                        </option>
                        <option value="berlangsung" @selected(request('status') === 'berlangsung')>
                            Berlangsung
                        </option>
                        <option value="selesai" @selected(request('status') === 'selesai')>
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M3 4h18l-7 8v6l-4 2v-8L3 4z"/>
                        </svg>
                        Filter
                    </button>

                    <a href="{{ route('penilaian.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Kelas</p>
                        <h3 class="mt-2 text-2xl font-bold text-gray-800">4</h3>
                    </div>
                    <div class="rounded-xl bg-[#E6F2DD] p-3 text-[#527b5d]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sedang Berlangsung</p>
                        <h3 class="mt-2 text-2xl font-bold text-emerald-700">2</h3>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M10 8l6 4-6 4V8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Selesai</p>
                        <h3 class="mt-2 text-2xl font-bold text-gray-800">1</h3>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Kelas Lomba --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="font-bold text-gray-800">Daftar Kelas Lomba</h2>
                <p class="text-sm text-gray-500">
                    Total: {{ count($kelasLomba) }} kelas
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="w-16 px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">No</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-[#24482f]">Kelas Lomba</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-[#24482f]">Acara</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Peserta</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Juri</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Status</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @php
                            $hasilFilter = collect($kelasLomba)->filter(function ($item) {
                                $search = strtolower(request('search', ''));
                                $status = request('status', '');

                                $sesuaiNama = $search === ''
                                    || str_contains(strtolower($item['nama']), $search)
                                    || str_contains(strtolower($item['acara']), $search);

                                $sesuaiStatus = $status === ''
                                    || $item['status'] === $status;

                                return $sesuaiNama && $sesuaiStatus;
                            })->values();
                        @endphp

                        @forelse($hasilFilter as $index => $kelas)
                            <tr class="transition-colors hover:bg-[#f8faf9]">
                                <td class="px-4 py-4 text-center text-sm font-semibold text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $kelas['nama'] }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $kelas['tanggal'] }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $kelas['acara'] }}
                                </td>

                                <td class="px-5 py-4 text-center text-sm text-gray-700">
                                    {{ $kelas['jumlah_peserta'] }} peserta
                                </td>

                                <td class="px-5 py-4 text-center text-sm text-gray-700">
                                    {{ $kelas['jumlah_juri'] }} juri
                                </td>

                                <td class="px-5 py-4 text-center">
                                    @if($kelas['status'] === 'berlangsung')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Berlangsung
                                        </span>
                                    @elseif($kelas['status'] === 'pendaftaran')
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Pendaftaran
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('penilaian.show', $kelas['id']) }}"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#527b5d] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#42684d]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <p class="text-sm text-gray-500">
                                        Tidak ada kelas lomba yang sesuai dengan filter.
                                    </p>
                                    <a href="{{ route('penilaian.index') }}"
                                        class="mt-2 inline-block text-sm font-semibold text-[#527b5d] hover:underline">
                                        Reset filter
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-5 py-4">
                <p class="text-xs text-gray-500">
                    Menampilkan {{ $hasilFilter->count() }} kelas lomba.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>