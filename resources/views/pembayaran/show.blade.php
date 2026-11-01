<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Detail Pembayaran</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Periksa informasi peserta dan verifikasi bukti pembayaran.
                    </p>
                </div>
                <div class="flex shrink-0">
                    <a href="{{ route('pembayaran.index') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Identitas Pembayaran --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">ID Pembayaran</p>
                    <h2 class="mt-1 text-xl font-bold text-gray-800">
                        #{{ str_pad($pembayaran->id_pembayaran, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                </div>

                <div>
                    @if($pembayaran->status === 'menunggu')
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Menunggu Verifikasi
                        </span>
                    @elseif($pembayaran->status === 'diterima')
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
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-800">A. Informasi Peserta</h2>
                    <p class="text-xs text-gray-500">Identitas peserta yang melakukan pembayaran.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">Nama Peserta</p>
                    <p class="font-semibold text-gray-800">{{ $pembayaran->peserta?->user?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">No. Telepon</p>
                    <p class="font-semibold text-gray-800">{{ $pembayaran->peserta?->user?->telepon ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="mb-1.5 text-sm text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800 break-all">{{ $pembayaran->peserta?->user?->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- B. Informasi Acara --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-800">B. Informasi Acara</h2>
                    <p class="text-xs text-gray-500">Acara dan kelas lomba yang diikuti peserta.</p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">Nama Acara</p>
                    <p class="font-semibold text-gray-800">{{ $pembayaran->peserta?->acara?->nama ?? '-' }}</p>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-bold text-gray-700">Kelas Lomba yang Diikuti</h3>
                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="w-full text-left">
                            <thead class="bg-[#527b5d]/10">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-[#24482f]">Kelas Lomba</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-[#24482f]">No. Gantangan</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider text-[#24482f]">Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-[#f8faf9]">
                                    <td class="px-4 py-3.5 text-sm font-medium text-gray-800">
                                        {{ $pembayaran->peserta?->kelasLomba?->nama ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-sm text-gray-700">
                                        {{ $pembayaran->peserta?->nomor_gantangan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right text-sm font-semibold text-gray-700">
                                        Rp{{ number_format($pembayaran->peserta?->harga ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-[#f8faf9]">
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-sm font-bold text-gray-800">Total Biaya</td>
                                    <td class="px-4 py-4 text-right text-base font-bold text-[#527b5d]">
                                        Rp{{ number_format($pembayaran->peserta?->harga ?? 0, 0, ',', '.') }}
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
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 15-5-5L5 21"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-800">C. Bukti Pembayaran</h2>
                    <p class="text-xs text-gray-500">Periksa bukti transfer yang diunggah peserta.</p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                <div>
                    <p class="mb-3 text-sm font-semibold text-gray-700">Foto Bukti Transfer</p>

                    @if($pembayaran->foto)
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-2">
                            <img src="{{ asset('storage/' . $pembayaran->foto) }}"
                                 alt="Bukti pembayaran"
                                 class="mx-auto max-h-[500px] w-full cursor-zoom-in rounded-lg object-contain"
                                 onclick="bukaPratinjau(this.src)">
                        </div>
                    @else
                        <div class="flex min-h-[220px] flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="font-semibold text-gray-700">Belum ada foto bukti pembayaran</p>
                        </div>
                    @endif
                </div>

                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-700">Keterangan Peserta</p>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5">
                        <p class="text-sm leading-relaxed text-gray-700">
                            {{ $pembayaran->keterangan ?: 'Tidak ada keterangan dari peserta.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- D. Verifikasi Pembayaran --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-800">D. Verifikasi Pembayaran</h2>
                    <p class="text-xs text-gray-500">Bagian ini digunakan oleh admin untuk memproses pembayaran.</p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                <div>
                    <p class="mb-2 text-sm text-gray-500">Status Verifikasi</p>
                    @if($pembayaran->status === 'menunggu')
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1.5 text-sm font-semibold text-amber-700">
                            Menunggu Verifikasi
                        </span>
                    @elseif($pembayaran->status === 'diterima')
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1.5 text-sm font-semibold text-emerald-700">
                            Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1.5 text-sm font-semibold text-red-700">
                            Ditolak
                        </span>
                    @endif
                </div>

                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-700">Catatan Admin</p>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5">
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ $pembayaran->catatan_admin ?: 'Belum ada catatan.' }}
                        </p>
                    </div>
                </div>

                @if($pembayaran->status === 'menunggu')
                    <form id="form-verifikasi" action="{{ route('pembayaran.update-status', $pembayaran) }}" method="POST" class="space-y-4 border-t border-gray-100 pt-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan Admin (opsional)</label>
                            <textarea name="catatan_admin" rows="2"
                                    class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_admin') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <button type="button"
                                    onclick="bukaKonfirmasi('ditolak')"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak Pembayaran
                            </button>

                            <button type="button"
                                    onclick="bukaKonfirmasi('diterima')"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Verifikasi Pembayaran
                            </button>
                        </div>

                        {{-- Hidden input untuk status --}}
                        <input type="hidden" name="status" id="input-status" value="">
                    </form>
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

    {{-- Modal Konfirmasi Verifikasi --}}
    <div id="modal-konfirmasi"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="mb-4 flex items-center gap-3">
                <div id="ikon-konfirmasi" class="flex h-11 w-11 items-center justify-center rounded-full">
                    {{-- diisi via JS --}}
                </div>
                <div>
                    <h3 id="judul-konfirmasi" class="text-lg font-bold text-gray-800">Konfirmasi</h3>
                    <p id="teks-konfirmasi" class="text-sm text-gray-500 mt-0.5">Apakah Anda yakin?</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="tutupKonfirmasi()"
                        class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="btn-ya-konfirmasi"
                        class="rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        const modalKonfirmasi = document.getElementById('modal-konfirmasi');

        document.body.appendChild(modalKonfirmasi);
        const formVerifikasi  = document.getElementById('form-verifikasi');
        const inputStatus     = document.getElementById('input-status');

        function bukaKonfirmasi(status) {
            const ikon   = document.getElementById('ikon-konfirmasi');
            const judul  = document.getElementById('judul-konfirmasi');
            const teks   = document.getElementById('teks-konfirmasi');
            const btnYa  = document.getElementById('btn-ya-konfirmasi');

            inputStatus.value = status;

            if (status === 'diterima') {
                ikon.className = 'flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100';
                ikon.innerHTML = `<svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>`;
                judul.textContent = 'Verifikasi Pembayaran';
                teks.textContent  = 'Apakah Anda yakin ingin menerima / memverifikasi pembayaran ini?';
                btnYa.className   = 'rounded-xl px-5 py-2.5 text-sm font-semibold text-white bg-[#527b5d] hover:bg-[#42684d] transition';
                btnYa.textContent = 'Ya, Verifikasi';
            } else {
                ikon.className = 'flex h-11 w-11 items-center justify-center rounded-full bg-red-100';
                ikon.innerHTML = `<svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>`;
                judul.textContent = 'Tolak Pembayaran';
                teks.textContent  = 'Apakah Anda yakin ingin menolak pembayaran ini?';
                btnYa.className   = 'rounded-xl px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition';
                btnYa.textContent = 'Ya, Tolak';
            }

            modalKonfirmasi.classList.remove('hidden');
            modalKonfirmasi.classList.add('flex');
        }

        function tutupKonfirmasi() {
            modalKonfirmasi.classList.add('hidden');
            modalKonfirmasi.classList.remove('flex');
        }

        // Klik di luar modal = tutup
        modalKonfirmasi.addEventListener('click', function(e) {
            if (e.target === modalKonfirmasi) tutupKonfirmasi();
        });

        // Tombol Ya → submit form
        document.getElementById('btn-ya-konfirmasi').addEventListener('click', function() {
            formVerifikasi.submit();
        });

        // ESC untuk tutup
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') tutupKonfirmasi();
        });
    </script>
</x-app-layout>