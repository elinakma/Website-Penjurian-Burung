<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                {{-- Judul --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">
                        Detail Pembayaran
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Periksa informasi peserta dan verifikasi bukti pembayaran.
                    </p>
                </div>

                {{-- Tombol Kembali --}}
                <div class="flex shrink-0">
                    <a href="{{ route('pembayaran.index') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        /*
        |----------------------------------------------------------
        | Data Statis
        |----------------------------------------------------------
        | Data ini nantinya dapat diganti dengan data dari database.
        */

        $pembayaran = [
            'id' => 'PAY-0001',
            'nama' => 'Budi Santoso',
            'telepon' => '0812-XXXX-XXXX',
            'email' => 'budi@example.com',
            'acara' => 'Lomba Burung Cup 2026',
            'kelas' => [
                [
                    'nama' => 'Murai Batu',
                    'harga' => 100000,
                ],
                [
                    'nama' => 'Cucak Hijau',
                    'harga' => 75000,
                ],
            ],
            'foto' => null,
            'keterangan' => 'Transfer melalui BCA.',
            'status' => 'menunggu',
            'catatan_admin' => null,
        ];

        $totalBiaya = collect($pembayaran['kelas'])->sum('harga');
    @endphp

    <div class="space-y-5">

        {{-- Identitas Pembayaran --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">ID Pembayaran</p>
                    <h2 class="mt-1 text-xl font-bold text-gray-800">
                        {{ $pembayaran['id'] }}
                    </h2>
                </div>

                {{-- Status Pembayaran --}}
                <div>
                    @if($pembayaran['status'] === 'menunggu')
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Menunggu Verifikasi
                        </span>
                    @elseif($pembayaran['status'] === 'diterima')
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- A. Informasi Peserta --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-gray-800">
                        A. Informasi Peserta
                    </h2>
                    <p class="text-xs text-gray-500">
                        Identitas peserta yang melakukan pembayaran.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">Nama Peserta</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran['nama'] }}
                    </p>
                </div>

                <div>
                    <p class="mb-1.5 text-sm text-gray-500">No. Telepon</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran['telepon'] }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="mb-1.5 text-sm text-gray-500">Email</p>
                    <p class="break-all font-semibold text-gray-800">
                        {{ $pembayaran['email'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- B. Informasi Acara --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-gray-800">
                        B. Informasi Acara
                    </h2>
                    <p class="text-xs text-gray-500">
                        Acara dan kelas lomba yang diikuti peserta.
                    </p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                {{-- Nama Acara --}}
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">Nama Acara</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran['acara'] }}
                    </p>
                </div>

                {{-- Daftar Kelas --}}
                <div>
                    <h3 class="mb-3 text-sm font-bold text-gray-700">
                        Kelas Lomba yang Diikuti
                    </h3>

                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="w-full text-left">
                            <thead class="bg-[#527b5d]/10">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                        No.
                                    </th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                        Kelas Lomba
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider text-[#24482f]">
                                        Biaya
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($pembayaran['kelas'] as $index => $kelas)
                                    <tr class="hover:bg-[#f8faf9]">
                                        <td class="px-4 py-3.5 text-sm text-gray-600">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800">
                                            {{ $kelas['nama'] }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3.5 text-right text-sm font-semibold text-gray-700">
                                            Rp{{ number_format($kelas['harga'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="bg-[#f8faf9]">
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-sm font-bold text-gray-800">
                                        Total Biaya
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-right text-base font-bold text-[#527b5d]">
                                        Rp{{ number_format($totalBiaya, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- C. Bukti Pembayaran --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"
                            stroke-width="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m21 15-5-5L5 21"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-gray-800">
                        C. Bukti Pembayaran
                    </h2>
                    <p class="text-xs text-gray-500">
                        Periksa bukti transfer yang diunggah peserta.
                    </p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                {{-- Foto Bukti --}}
                <div>
                    <p class="mb-3 text-sm font-semibold text-gray-700">
                        Foto Bukti Transfer
                    </p>

                    @if($pembayaran['foto'])
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-2">
                            <img src="{{ asset('storage/' . $pembayaran['foto']) }}"
                                alt="Bukti pembayaran {{ $pembayaran['nama'] }}"
                                class="mx-auto max-h-[500px] w-full cursor-zoom-in rounded-lg object-contain"
                                onclick="bukaPratinjau(this.src)">
                        </div>
                    @else
                        {{-- Placeholder sebelum database tersedia --}}
                        <div class="flex min-h-[220px] flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E6F2DD] text-[#527b5d]">
                                <svg class="h-7 w-7" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18"
                                        rx="2" stroke-width="1.8"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"
                                        stroke-width="1.8"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.8" d="m21 15-5-5L5 21"/>
                                </svg>
                            </div>

                            <p class="font-semibold text-gray-700">
                                Belum ada foto bukti pembayaran
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Pratinjau bukti pembayaran akan ditampilkan di sini.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Keterangan Peserta --}}
                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-700">
                        Keterangan Peserta
                    </p>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5">
                        <p class="text-sm leading-relaxed text-gray-700">
                            {{ $pembayaran['keterangan'] ?: 'Tidak ada keterangan dari peserta.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- D. Verifikasi Pembayaran --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-gray-800">
                        D. Verifikasi Pembayaran
                    </h2>
                    <p class="text-xs text-gray-500">
                        Bagian ini digunakan oleh admin untuk memproses pembayaran.
                    </p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                {{-- Status Verifikasi --}}
                <div>
                    <p class="mb-2 text-sm text-gray-500">
                        Status Verifikasi
                    </p>

                    @if($pembayaran['status'] === 'menunggu')
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1.5 text-sm font-semibold text-amber-700">
                            Menunggu Verifikasi
                        </span>
                    @elseif($pembayaran['status'] === 'diterima')
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1.5 text-sm font-semibold text-emerald-700">
                            Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1.5 text-sm font-semibold text-red-700">
                            Ditolak
                        </span>
                    @endif
                </div>

                {{-- Catatan Admin --}}
                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-700">
                        Catatan Admin
                    </p>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5">
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ $pembayaran['catatan_admin'] ?: 'Belum ada catatan.' }}
                        </p>
                    </div>
                </div>

                {{-- Tombol Verifikasi --}}
                @if($pembayaran['status'] === 'menunggu')
                    <div class="border-t border-gray-100 pt-5">
                        <p class="mb-4 text-sm text-gray-500">
                            Pastikan bukti pembayaran dan nominal transfer sesuai sebelum mengambil keputusan.
                        </p>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <button type="button"
                                onclick="alert('Fitur penolakan akan diaktifkan setelah controller dan database tersedia.')"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50 active:scale-[0.98]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak Pembayaran
                            </button>

                            <button type="button"
                                onclick="alert('Fitur verifikasi akan diaktifkan setelah controller dan database tersedia.')"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#42684d] active:scale-[0.98]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Verifikasi Pembayaran
                            </button>
                        </div>
                    </div>
                @else
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <p class="text-sm text-gray-600">
                            Pembayaran ini sudah diproses. Tidak ada tindakan verifikasi yang tersedia.
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Modal Pratinjau Gambar --}}
    <div id="modal-pratinjau"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-4"
        onclick="tutupPratinjau()">

        <button type="button"
            onclick="tutupPratinjau()"
            class="absolute right-5 top-5 rounded-full bg-white/20 p-2 text-white transition hover:bg-white/30"
            aria-label="Tutup pratinjau">
            <svg class="h-6 w-6" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <img id="gambar-pratinjau"
            src=""
            alt="Pratinjau bukti pembayaran"
            class="max-h-[90vh] max-w-full rounded-xl object-contain shadow-2xl"
            onclick="event.stopPropagation()">
    </div>

    {{-- Script Pratinjau --}}
    <script>
        function bukaPratinjau(src) {
            const modal = document.getElementById('modal-pratinjau');
            const gambar = document.getElementById('gambar-pratinjau');

            gambar.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function tutupPratinjau() {
            const modal = document.getElementById('modal-pratinjau');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                tutupPratinjau();
            }
        });
    </script>
</x-app-layout>