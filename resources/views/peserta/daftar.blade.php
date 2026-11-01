<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl px-6 py-4 sm:px-8 sm:py-5 shadow-sm"
        style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div>
                <h1 class="text-2xl font-bold text-[#0e1e17]">Form Pendaftaran Lomba</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang <span class="font-medium text-[#527b5d]">{{ Auth::user()->name }}</span>, Isi data burung dan diri Anda untuk mengikuti lomba.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="pt-0 pb-5">
        <div class="w-full mx-auto max-w-3xl">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <form id="form-peserta" action="{{ route('peserta.daftar.store') }}" method="POST" class="px-5 pt-3 pb-6 sm:px-6 sm:pt-4 sm:pb-6 space-y-5">
                    @csrf

                    {{-- Nama Burung --}}
                    <div>
                        <label for="nama_burung" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Burung <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_burung" id="nama_burung" value="{{ old('nama_burung') }}"
                            placeholder="Contoh: Murai Batu Super"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition"
                            required>
                        @error('nama_burung')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                                placeholder="Alamat lengkap Anda"
                                class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition"
                                required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Acara (otomatis dari acara yang sedang berlangsung) --}}
                    <div>
                        <label for="acara_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Acara <span class="text-red-500">*</span>
                        </label>

                        @if($acaras->isEmpty())
                            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                Saat ini tidak ada acara yang sedang berlangsung. Pendaftaran ditutup.
                            </div>
                            <input type="hidden" name="acara_id" value="">
                        @else
                            <select name="acara_id" id="acara_id"
                                    class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition"
                                    required>
                                <option value="">-- Pilih Acara --</option>
                                @foreach($acaras as $acara)
                                    <option value="{{ $acara->id_acara }}"
                                        {{ old('acara_id', $acaras->count() === 1 ? $acara->id_acara : '') == $acara->id_acara ? 'selected' : '' }}>
                                        {{ $acara->nama }}
                                        ({{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }})
                                        — {{ $acara->status }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @error('acara_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Burung --}}
                    <div>
                        <label for="jenis_burung" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Jenis Burung <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_burung" id="jenis_burung"
                                class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition"
                                required {{ $acaras->isEmpty() ? 'disabled' : '' }}>
                            <option value="">-- Pilih Jenis Burung --</option>
                            @foreach($burungs as $burung)
                                <option value="{{ $burung->id }}" {{ old('jenis_burung') == $burung->id ? 'selected' : '' }}>
                                    {{ $burung->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_burung')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kelas Lomba (terfilter berdasarkan Acara + Jenis Burung) --}}
                    <div>
                        <label for="kelas_lomba" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Kelas Lomba <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_lomba" id="kelas_lomba"
                                class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] transition"
                                required disabled>
                            <option value="">-- Pilih Acara & Jenis Burung terlebih dahulu --</option>
                        </select>
                        @error('kelas_lomba')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tiket --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Tiket / Harga
                        </label>
                        <input type="text" id="tiket_display"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700"
                            placeholder="Pilih kelas lomba terlebih dahulu" readonly>
                        <input type="hidden" name="tiket" id="tiket">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="button" id="btn-simpan"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-6 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d] active:scale-[0.98]"
                                {{ $acaras->isEmpty() ? 'disabled' : '' }}>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Daftar Sekarang
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
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Pendaftaran</h3>
            </div>
            <p class="mb-6 text-sm text-gray-600">
                Apakah Anda yakin ingin mendaftar dengan data yang sudah diisi?
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="btn-batal-modal"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="btn-ya-modal"
                        class="rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                    Ya, Daftar
                </button>
            </div>
        </div>
    </div>

    <script>
    const semuaKelas = @json($kelasLombas ?? []);

    const acaraSelect       = document.getElementById('acara_id');
    const jenisBurungSelect = document.getElementById('jenis_burung');
    const kelasLombaSelect  = document.getElementById('kelas_lomba');
    const tiketDisplay      = document.getElementById('tiket_display');
    const tiketInput        = document.getElementById('tiket');

    function resetKelasDanTiket() {
        kelasLombaSelect.innerHTML = '<option value="">-- Pilih Kelas Lomba --</option>';
        kelasLombaSelect.disabled = true;
        tiketDisplay.value = '';
        tiketInput.value = '';
    }

    function filterKelas() {
        const acaraId  = acaraSelect?.value;
        const burungId = jenisBurungSelect.value;

        resetKelasDanTiket();

        if (!acaraId || !burungId) return;

        const filtered = semuaKelas.filter(kelas => 
            kelas.acara_id == acaraId && kelas.burung_id == burungId
        );

        if (filtered.length === 0) {
            kelasLombaSelect.innerHTML = '<option value="">Tidak ada kelas untuk kombinasi ini</option>';
            return;
        }

        filtered.forEach(kelas => {
            const option = document.createElement('option');
            option.value = kelas.id_kelas;
            option.textContent = `${kelas.nama} - Rp ${Number(kelas.harga).toLocaleString('id-ID')}`;
            option.dataset.harga = kelas.harga;
            kelasLombaSelect.appendChild(option);
        });

        kelasLombaSelect.disabled = false;
    }

    // Event listeners
    if (acaraSelect) {
        acaraSelect.addEventListener('change', filterKelas);
    }
    jenisBurungSelect.addEventListener('change', filterKelas);

    kelasLombaSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.dataset.harga;

        if (harga) {
            tiketDisplay.value = 'Rp ' + Number(harga).toLocaleString('id-ID');
            tiketInput.value = harga;
        } else {
            tiketDisplay.value = '';
            tiketInput.value = '';
        }
    });

    // Modal
    const form = document.getElementById('form-peserta');
    const btnSimpan = document.getElementById('btn-simpan');
    const modal = document.getElementById('modal-konfirmasi');
    const btnBatal = document.getElementById('btn-batal-modal');
    const btnYa = document.getElementById('btn-ya-modal');

    btnSimpan.addEventListener('click', function () {
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    btnBatal.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    btnYa.addEventListener('click', function () {
        form.submit();
    });
    </script>
</x-app-layout>