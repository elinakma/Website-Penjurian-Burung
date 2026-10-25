<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Tambah Acara</h1>
                    <p class="text-sm text-gray-600 mt-1">Lengkapi informasi acara untuk menjadwalkan perlombaan baru.</p>
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
        <div class="w-full mx-auto">
            <div class="bg-white rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                <form id="form-acara" action="{{ route('acara.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    {{-- Nama Acara --}}
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                               placeholder="Contoh: Kontes Murai Batu dan Cucak Hijau"
                               class="w-full rounded-xl border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition @error('nama') border-red-400 @enderror"
                               required>
                        @error('nama')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Tanggal Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                               class="w-full rounded-xl border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition @error('tanggal') border-red-400 @enderror"
                               required>
                        @error('tanggal')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}"
                               placeholder="Contoh: Lapangan Desa / Aula Kantor Kecamatan"
                               class="w-full rounded-xl border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition @error('lokasi') border-red-400 @enderror"
                               required>
                        @error('lokasi')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('acara.index') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="button" id="btn-simpan"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d] active:scale-[0.98]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Acara
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Overlay Konfirmasi --}}
    <div id="modal-konfirmasi" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Simpan</h3>
            </div>
            <p class="mb-6 text-sm text-gray-600">
                Apakah Anda yakin ingin menyimpan acara ini?
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="btn-batal-modal"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="btn-ya-modal"
                        class="rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('form-acara');
        const btnSimpan = document.getElementById('btn-simpan');
        const modal = document.getElementById('modal-konfirmasi');
        const btnBatal = document.getElementById('btn-batal-modal');
        const btnYa = document.getElementById('btn-ya-modal');

        // Tampilkan modal saat klik Simpan
        btnSimpan.addEventListener('click', function () {
            // Validasi HTML5 dulu
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        // Tutup modal
        btnBatal.addEventListener('click', function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        // Klik di luar modal juga menutup
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        // Submit form jika user klik Ya
        btnYa.addEventListener('click', function () {
            form.submit();
        });
    </script>
</x-app-layout>