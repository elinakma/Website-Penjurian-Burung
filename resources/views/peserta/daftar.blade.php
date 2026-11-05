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

                    {{-- Nama Pemilik (otomatis) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Pemilik
                        </label>
                        <input type="text"
                            value="{{ Auth::user()->name }}"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700"
                            readonly>
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

                    {{-- Nama Acara --}}
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

                    {{-- Kelas Lomba (multi checkbox - berdasarkan acara saja) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Kelas Lomba <span class="text-red-500">*</span>
                            <span class="text-xs font-normal text-gray-500">(bisa pilih lebih dari satu)</span>
                        </label>

                        <div id="kelas-lomba-container"
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4 space-y-2 max-h-72 overflow-y-auto">
                            <p class="text-sm text-gray-500">Pilih Acara terlebih dahulu</p>
                        </div>

                        @error('kelas_lomba')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('kelas_lomba.*')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Pembayaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Total Pembayaran
                        </label>
                        <input type="text" id="tiket_display"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 font-semibold"
                            value="Rp 0" readonly>
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

    const acaraSelect  = document.getElementById('acara_id');
    const container    = document.getElementById('kelas-lomba-container');
    const tiketDisplay = document.getElementById('tiket_display');

    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('input[name="kelas_lomba[]"]:checked').forEach(cb => {
            total += Number(cb.dataset.harga || 0);
        });
        tiketDisplay.value = formatRupiah(total);
    }

    function filterKelas() {
        const acaraId = acaraSelect?.value;
        container.innerHTML = '';

        if (!acaraId) {
            container.innerHTML = '<p class="text-sm text-gray-500">Pilih Acara terlebih dahulu</p>';
            tiketDisplay.value = 'Rp 0';
            return;
        }

        const filtered = semuaKelas.filter(kelas => kelas.acara_id == acaraId);

        if (filtered.length === 0) {
            container.innerHTML = '<p class="text-sm text-red-600">Tidak ada kelas lomba untuk acara ini</p>';
            tiketDisplay.value = 'Rp 0';
            return;
        }

        filtered.forEach(kelas => {
            const label = document.createElement('label');
            label.className = 'flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white cursor-pointer hover:border-[#527b5d] transition';

            const namaBurung = kelas.burung ? kelas.burung.nama : '-';

            label.innerHTML = `
                <input type="checkbox"
                    name="kelas_lomba[]"
                    value="${kelas.id_kelas}"
                    data-harga="${kelas.harga}"
                    class="rounded border-gray-300 text-[#527b5d] focus:ring-[#527b5d]">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800">${kelas.nama}</p>
                    <p class="text-xs text-gray-500">${namaBurung} • Kuota: ${kelas.kuota}</p>
                </div>
                <span class="text-sm font-semibold text-[#527b5d] whitespace-nowrap">
                    ${formatRupiah(kelas.harga)}
                </span>
            `;

            container.appendChild(label);
        });

        container.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', hitungTotal);
        });

        hitungTotal();
    }

    if (acaraSelect) {
        acaraSelect.addEventListener('change', filterKelas);

        // Auto load jika hanya 1 acara
        if (acaraSelect.value) {
            filterKelas();
        }
    }

    // Modal konfirmasi
    const form      = document.getElementById('form-peserta');
    const btnSimpan = document.getElementById('btn-simpan');
    const modal     = document.getElementById('modal-konfirmasi');
    const btnBatal  = document.getElementById('btn-batal-modal');
    const btnYa     = document.getElementById('btn-ya-modal');

    btnSimpan.addEventListener('click', function () {
        const checked = document.querySelectorAll('input[name="kelas_lomba[]"]:checked');
        if (checked.length === 0) {
            alert('Pilih minimal satu kelas lomba.');
            return;
        }
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