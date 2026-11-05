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
        @if(session('error'))
            <div class="rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if(session('wa_url'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-emerald-800">Pembayaran Berhasil Diverifikasi</h3>
                        <p class="text-sm text-emerald-700 mt-1">
                            Silakan kirim konfirmasi ke peserta melalui WhatsApp.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Tombol Download QR --}}
                        <a href="{{ session('qr_url') }}" download="qr-lunas.png"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-300 bg-white px-5 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download QR
                        </a>

                        {{-- Tombol Kirim via WhatsApp --}}
                        <a href="{{ session('wa_url') }}" target="_blank"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#25D366] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1da851] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Kirim via WhatsApp
                        </a>
                    </div>
                </div>

                {{-- Preview QR kecil --}}
                <div class="mt-4 flex items-center gap-4">
                    <img src="{{ session('qr_url') }}" alt="QR Code" class="w-24 h-24 rounded-lg border border-emerald-200">
                    <div class="text-sm text-emerald-800">
                        <p class="font-medium">QR Code sudah siap</p>
                        <p class="text-emerald-600 mt-0.5">Download lalu kirim ke nomor: <strong>{{ session('nomor_peserta') }}</strong></p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Identitas Pembayaran --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        {{ $pembayaran ? 'ID Pembayaran' : 'Detail Pendaftaran' }}
                    </p>
                    <h2 class="mt-1 text-xl font-bold text-gray-800">
                        @if($pembayaran)
                            #{{ str_pad($pembayaran->id_pembayaran, 5, '0', STR_PAD_LEFT) }}
                        @else
                            Belum ada bukti
                        @endif
                    </h2>
                </div>

                <div>
                    @if(!$pembayaran)
                        <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">
                            <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                            Belum Upload Bukti
                        </span>
                    @elseif($pembayaran->status === 'menunggu')
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
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran?->peserta?->user?->name ?? $peserta->user?->name ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="mb-1.5 text-sm text-gray-500">No. Telepon</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran?->peserta?->user?->phone ?? $peserta->user?->phone ?? '-' }}
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <p class="mb-1.5 text-sm text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800 break-all">
                        {{ $pembayaran?->peserta?->user?->email ?? $peserta->user?->email ?? '-' }}
                    </p>
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
                    <p class="font-semibold text-gray-800">
                        {{ $pembayaran?->peserta?->acara?->nama ?? $peserta->acara?->nama ?? '-' }}
                    </p>
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
                           <tbody class="divide-y divide-gray-100">
                                @foreach($daftarKelas as $row)
                                    <tr class="hover:bg-[#f8faf9]">
                                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800">
                                            {{ $row->kelasLomba?->nama ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm text-gray-700">
                                            {{ $row->nomor_gantangan ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3.5 text-right text-sm font-semibold text-gray-700">
                                            Rp{{ number_format($row->harga ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-[#f8faf9]">
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-sm font-bold text-gray-800">
                                        Total Biaya ({{ $daftarKelas->count() }} kelas)
                                    </td>
                                    <td class="px-4 py-4 text-right text-base font-bold text-[#527b5d]">
                                        Rp{{ number_format($totalBayar, 0, ',', '.') }}
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

                    @if($pembayaran)
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-2">
                            <img src="{{ asset('storage/' . $pembayaran->foto) }}"
                                 alt="Bukti pembayaran"
                                 class="mx-auto max-h-[500px] w-full cursor-zoom-in rounded-lg object-contain"
                                 onclick="window.open(this.src, '_blank')">
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-8 text-center">
                            <p class="font-semibold text-gray-700">Peserta belum mengupload bukti pembayaran</p>
                            <p class="text-sm text-gray-500 mt-1">
                                Total yang harus dibayar: 
                                <span class="font-bold text-[#527b5d]">Rp{{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    @endif
                </div>

                <div>
                    <p class="mb-2 text-sm font-semibold text-gray-700">Keterangan Peserta</p>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5">
                        <p class="text-sm leading-relaxed text-gray-700">
                            {{ $pembayaran?->keterangan ?: 'Tidak ada keterangan dari peserta.' }}
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
                @if(!$pembayaran)
                    <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-6 text-center">
                        <p class="font-semibold text-gray-700">Peserta belum mengupload bukti pembayaran</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Tidak ada tindakan verifikasi yang dapat dilakukan.
                        </p>
                    </div>
                @else
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
                                    Tolak Pembayaran
                                </button>

                                <button type="button"
                                        onclick="bukaKonfirmasi('diterima')"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                                    Verifikasi Pembayaran
                                </button>
                            </div>

                            <input type="hidden" name="status" id="input-status" value="">
                        </form>
                    @else
                        <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <p class="text-sm text-gray-600">
                                Pembayaran ini sudah diproses. Tidak ada tindakan verifikasi yang tersedia.
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Berhasil --}}
    @if(session('success'))
    <div id="modal-berhasil"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Berhasil</h3>
                    <p class="text-sm text-gray-500 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>

            @if(session('wa_url'))
                <div class="mb-4 flex items-center gap-4 rounded-xl border border-emerald-100 bg-emerald-50 p-3">
                    <img src="{{ session('qr_url') }}" alt="QR" class="h-20 w-20 rounded-lg border border-emerald-200">
                    <p class="text-sm text-emerald-800">
                        Kirim konfirmasi ke <strong>{{ session('nomor_peserta') }}</strong> lewat WhatsApp.
                    </p>
                </div>
            @endif

            @if(session('error'))
                <p class="mb-4 rounded-xl bg-red-50 px-3 py-2 text-sm text-red-700">{{ session('error') }}</p>
            @endif

            <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                <button type="button" onclick="document.getElementById('modal-berhasil').remove()"
                        class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
                @if(session('wa_url'))
                    <a href="{{ session('wa_url') }}" target="_blank" rel="noopener"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#25D366] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1da851]">
                        Kirim via WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endif

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

        const formVerifikasi = document.getElementById('form-verifikasi');
        const inputStatus    = document.getElementById('input-status');

        function bukaKonfirmasi(status) {
            if (!formVerifikasi) return;

            const ikon  = document.getElementById('ikon-konfirmasi');
            const judul = document.getElementById('judul-konfirmasi');
            const teks  = document.getElementById('teks-konfirmasi');
            const btnYa = document.getElementById('btn-ya-konfirmasi');

            inputStatus.value = status;

            if (status === 'diterima') {
                ikon.className = 'flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100';
                ikon.innerHTML = `<svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
                judul.textContent = 'Verifikasi Pembayaran';
                teks.textContent  = 'Apakah Anda yakin ingin menerima / memverifikasi pembayaran ini?';
                btnYa.className   = 'rounded-xl px-5 py-2.5 text-sm font-semibold text-white bg-[#527b5d] hover:bg-[#42684d] transition';
                btnYa.textContent = 'Ya, Verifikasi';
            } else {
                ikon.className = 'flex h-11 w-11 items-center justify-center rounded-full bg-red-100';
                ikon.innerHTML = `<svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
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

        modalKonfirmasi.addEventListener('click', function(e) {
            if (e.target === modalKonfirmasi) tutupKonfirmasi();
        });

        if (document.getElementById('btn-ya-konfirmasi')) {
            document.getElementById('btn-ya-konfirmasi').addEventListener('click', function() {
                if (formVerifikasi) formVerifikasi.submit();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') tutupKonfirmasi();
        });

        // Jika halaman dipulihkan dari cache (tombol Kembali), muat ulang dari server
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) {
                window.location.reload();
            }
        });

        // Cegah klik ganda pada tombol "Ya"
        document.getElementById('btn-ya-konfirmasi').addEventListener('click', function () {
            this.disabled = true;
            this.textContent = 'Memproses...';
        });c
    </script>
</x-app-layout>