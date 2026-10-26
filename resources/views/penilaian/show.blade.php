<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 shadow-sm sm:p-8"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">
                        Papan Penilaian
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Pilih nomor peserta sesuai hasil penilaian juri.
                    </p>
                </div>

                <a href="{{ route('penilaian.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $acara = 'Lomba Burung Cup 2026';
        $namaKelas = 'Murai Batu C Kamulyan';

        // Data peserta statis untuk simulasi.
        $peserta = [
            ['nomor' => 1, 'burung' => 'Singo Barong', 'pemilik' => 'Ahmat Galaxy', 'kategori' => 'A'],
            ['nomor' => 2, 'burung' => 'Rasputin', 'pemilik' => 'Budi Kentheng Pathi', 'kategori' => 'A'],
            ['nomor' => 3, 'burung' => 'Gobet', 'pemilik' => 'Rauf Jangkar 46', 'kategori' => 'A'],
            ['nomor' => 4, 'burung' => 'Moreno', 'pemilik' => 'Talam SF', 'kategori' => 'A'],
            ['nomor' => 5, 'burung' => 'Jiwangga', 'pemilik' => 'Harist Gustian', 'kategori' => 'A'],
            ['nomor' => 6, 'burung' => 'Bintang Timur', 'pemilik' => 'Joko BRS', 'kategori' => 'A'],
            ['nomor' => 7, 'burung' => 'Megatron', 'pemilik' => 'Bukit Batik', 'kategori' => 'B'],
            ['nomor' => 8, 'burung' => 'Ombak', 'pemilik' => 'Pandana', 'kategori' => 'B'],
            ['nomor' => 9, 'burung' => 'Sinchan', 'pemilik' => 'Kace', 'kategori' => 'B'],
            ['nomor' => 10, 'burung' => 'Jungkir Naut', 'pemilik' => 'Fiyan Diak', 'kategori' => 'B'],
            ['nomor' => 11, 'burung' => 'Rawing', 'pemilik' => 'Jangkar Miring', 'kategori' => 'B'],
            ['nomor' => 12, 'burung' => 'Sniper', 'pemilik' => 'Very Irwawan', 'kategori' => 'B'],
            ['nomor' => 13, 'burung' => 'Nodhil', 'pemilik' => 'JRP', 'kategori' => 'C'],
            ['nomor' => 14, 'burung' => 'Pajero', 'pemilik' => 'Fajar Alwi', 'kategori' => 'C'],
            ['nomor' => 15, 'burung' => 'Purnama', 'pemilik' => 'Mr Dan', 'kategori' => 'C'],
            ['nomor' => 16, 'burung' => 'Bramasta', 'pemilik' => 'Ilham Farjin', 'kategori' => 'C'],
            ['nomor' => 17, 'burung' => 'Nochil', 'pemilik' => 'JRP', 'kategori' => 'C'],
            ['nomor' => 18, 'burung' => 'Golden Boy', 'pemilik' => 'Remsi SF Jepara', 'kategori' => 'C'],
            ['nomor' => 19, 'burung' => 'Prasasti', 'pemilik' => 'Tebu Balap', 'kategori' => 'D'],
            ['nomor' => 20, 'burung' => 'Reborn', 'pemilik' => 'IPPN', 'kategori' => 'D'],
            ['nomor' => 21, 'burung' => 'Hitler', 'pemilik' => 'Totok Gugeg', 'kategori' => 'D'],
            ['nomor' => 22, 'burung' => 'Barong', 'pemilik' => 'Haidar Putra Daging', 'kategori' => 'D'],
            ['nomor' => 23, 'burung' => 'Arik Kobra', 'pemilik' => 'Arik Kobra SF', 'kategori' => 'D'],
            ['nomor' => 24, 'burung' => 'Warok', 'pemilik' => 'Sandi Teamwon SF', 'kategori' => 'D'],
        ];

        // Pilihan awal untuk simulasi. Nilai kosong berarti belum memilih.
        $pilihanAwal = [
            'A' => [14, 13, 1, 16, 20, 21],
            'B' => [12, 14, 16, 18, 21, 24],
            'C' => [1, 8, 13, 14, 16, 18],
            'D' => [1, 12, 13, 14, 21, 22],
        ];

        $juri = [
            ['kode' => 'A', 'nama' => 'Lion'],
            ['kode' => 'B', 'nama' => 'Nanda'],
            ['kode' => 'C', 'nama' => 'Bagus'],
            ['kode' => 'D', 'nama' => 'Fery'],
        ];
    @endphp

    <div class="space-y-5">

{{-- Informasi Kelas --}}
<div class="overflow-hidden rounded-2xl shadow-sm">
    {{-- Header dengan gradient hijau muda + emas --}}
    <div class="relative p-5 sm:p-6"
         style="background: linear-gradient(135deg, #E8F5E0 0%, #C8E6B0 40%, #D4AF37 100%);">
        
        {{-- dekorasi blur --}}
        <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/30 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-6 -left-6 h-24 w-24 rounded-full bg-[#D4AF37]/25 blur-xl"></div>

        <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-black/70">
                    {{ $acara }}
                </p>
                <h2 class="mt-2 text-xl font-bold text-black sm:text-2xl">
                    {{ $namaKelas }}
                </h2>
                <p class="mt-1 text-sm text-black/80">
                    24 peserta &middot; 4 juri &middot; 6 pilihan per juri
                </p>
            </div>

            <span class="inline-flex w-fit items-center gap-2 rounded-full border border-black/10 bg-white/70 px-4 py-2 text-sm font-semibold text-black shadow-sm backdrop-blur-sm">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
                Penilaian Berlangsung
            </span>
        </div>
    </div>

    {{-- Stats dalam 4 card sejajar --}}
    <div class="grid grid-cols-2 gap-3 bg-white p-4 sm:grid-cols-4 sm:gap-4 sm:p-5">
        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-4 text-center shadow-sm">
            <p class="text-xs font-medium text-gray-500">Jumlah Peserta</p>
            <p class="mt-1.5 text-2xl font-bold text-black">24</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-4 text-center shadow-sm">
            <p class="text-xs font-medium text-gray-500">Jumlah Juri</p>
            <p class="mt-1.5 text-2xl font-bold text-black">4</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-4 text-center shadow-sm">
            <p class="text-xs font-medium text-gray-500">Total Pilihan</p>
            <p id="total-pilihan" class="mt-1.5 text-2xl font-bold text-[#527b5d]">24</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-4 text-center shadow-sm">
            <p class="text-xs font-medium text-gray-500">Peserta Terpilih</p>
            <p id="total-peserta-terpilih" class="mt-1.5 text-2xl font-bold text-black">--</p>
        </div>
    </div>
</div>
        {{-- Daftar Peserta --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="font-bold text-gray-800">Daftar Peserta</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Referensi nomor peserta, nama burung, dan pemilik.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[650px] text-left">
                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">No. Peserta</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase text-[#24482f]">Nama Burung</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase text-[#24482f]">Pemilik</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($peserta as $p)
                            <tr class="hover:bg-[#f8faf9]">
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#527b5d] px-2 text-sm font-bold text-white">
                                        {{ $p['nomor'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                                    {{ $p['burung'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $p['pemilik'] }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-700">
                                        {{ $p['kategori'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Panel Pilihan Juri --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="font-bold text-gray-800">Pilihan Juri</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Pilih nomor peserta pada setiap slot. Perubahan akan memperbarui simulasi rekap suara.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($juri as $item)
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center gap-3 bg-[#527b5d] px-4 py-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-base font-bold text-[#527b5d]">
                                {{ $item['kode'] }}
                            </span>
                            <div>
                                <h3 class="font-bold text-white">Juri {{ $item['kode'] }}</h3>
                                <p class="text-xs text-green-100">{{ $item['nama'] }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 p-3">
                            @for($slot = 1; $slot <= 6; $slot++)
                                <div>
                                    <label for="juri-{{ $item['kode'] }}-slot-{{ $slot }}"
                                        class="mb-1 block text-xs font-semibold text-gray-600">
                                        Pilihan {{ $slot }}
                                    </label>

                                    <select
                                        id="juri-{{ $item['kode'] }}-slot-{{ $slot }}"
                                        class="pilihan-juri w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                                        data-juri="{{ $item['kode'] }}"
                                        data-slot="{{ $slot }}"
                                        aria-label="Pilihan {{ $slot }} Juri {{ $item['kode'] }}">

                                        <option value="">Pilih peserta</option>

                                        @foreach($peserta as $p)
                                            <option
                                                value="{{ $p['nomor'] }}"
                                                @selected(($pilihanAwal[$item['kode']][$slot - 1] ?? null) === $p['nomor'])>
                                                {{ $p['nomor'] }} - {{ $p['burung'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endfor

                            <p class="border-t border-gray-100 pt-3 text-xs text-gray-500">
                                Terisi:
                                <span id="jumlah-juri-{{ $item['kode'] }}" class="font-bold text-[#527b5d]">6</span>/6 pilihan
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 bg-gray-50 px-5 py-4">
                <p class="text-xs leading-relaxed text-gray-500">
                    Catatan: pilihan awal hanya contoh. Simulasi ini belum menyimpan perubahan ke database.
                </p>
            </div>
        </div>

        {{-- Rekap Suara --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-bold text-gray-800">Rekapitulasi Perolehan Suara</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Urutan peserta berdasarkan jumlah suara tertinggi.
                    </p>
                </div>
                <span class="w-fit rounded-full bg-[#E6F2DD] px-3 py-1 text-xs font-semibold text-[#24482f]">
                    Simulasi Langsung
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-left">
                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="w-16 px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">Peringkat</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">No. Peserta</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase text-[#24482f]">Nama Burung</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">Perolehan Suara</th>
                        </tr>
                    </thead>
                    <tbody id="rekap-suara" class="divide-y divide-gray-100">
                        {{-- Diisi oleh JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Daftar Jawara --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M8 21h8m-4-4v4m-7-18h14v7a7 7 0 01-14 0V3zm0 2H3v3a5 5 0 005 5m11-8h2v3a5 5 0 01-5 5"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-800">Daftar Jawara</h2>
                    <p class="text-xs text-gray-500">
                        Peringkat sementara berdasarkan perolehan suara.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[550px] text-left">
                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">Juara</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">No. Peserta</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase text-[#24482f]">Nama Burung</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase text-[#24482f]">Pemilik</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase text-[#24482f]">Suara</th>
                        </tr>
                    </thead>
                    <tbody id="daftar-jawara" class="divide-y divide-gray-100">
                        {{-- Diisi oleh JavaScript --}}
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-5 py-4">
                <p class="text-xs leading-relaxed text-gray-500">
                    Peringkat pada halaman ini masih sementara. Penetapan juara resmi perlu mengikuti aturan lomba, termasuk aturan jika jumlah suara sama.
                </p>
            </div>
        </div>
    </div>

    {{-- Simulasi Perhitungan Suara di Browser --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const peserta = @json($peserta);
            const selects = document.querySelectorAll('.pilihan-juri');

            function hitungSuara() {
                const suara = {};
                let totalPilihan = 0;
                const pesertaTerpilih = new Set();

                peserta.forEach(function (p) {
                    suara[p.nomor] = 0;
                });

                // Hitung suara dari semua pilihan juri.
                selects.forEach(function (select) {
                    const nomor = select.value;

                    if (nomor !== '' && suara[nomor] !== undefined) {
                        suara[nomor]++;
                        totalPilihan++;
                        pesertaTerpilih.add(nomor);
                    }
                });

                // Perbarui jumlah pilihan tiap juri.
                ['A', 'B', 'C', 'D'].forEach(function (kode) {
                    const slotJuri = document.querySelectorAll(
                        '.pilihan-juri[data-juri="' + kode + '"]'
                    );

                    const terisi = Array.from(slotJuri).filter(
                        select => select.value !== ''
                    ).length;

                    document.getElementById('jumlah-juri-' + kode).textContent = terisi;
                });

                document.getElementById('total-pilihan').textContent = totalPilihan;
                document.getElementById('total-peserta-terpilih').textContent =
                    pesertaTerpilih.size;

                // Susun peringkat dari suara terbanyak.
                const hasil = peserta
                    .map(function (p) {
                        return {
                            ...p,
                            suara: suara[p.nomor]
                        };
                    })
                    .filter(function (p) {
                        return p.suara > 0;
                    })
                    .sort(function (a, b) {
                        return b.suara - a.suara || a.nomor - b.nomor;
                    });

                const rekap = document.getElementById('rekap-suara');
                const jawara = document.getElementById('daftar-jawara');

                rekap.innerHTML = '';
                jawara.innerHTML = '';

                if (hasil.length === 0) {
                    rekap.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-gray-500">
                                Belum ada peserta yang dipilih oleh juri.
                            </td>
                        </tr>
                    `;

                    jawara.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                                Belum ada hasil penilaian.
                            </td>
                        </tr>
                    `;

                    return;
                }

                // Tampilkan semua peserta yang memperoleh suara.
                hasil.forEach(function (p, index) {
                    const baris = document.createElement('tr');
                    baris.className = 'hover:bg-[#f8faf9]';

                    baris.innerHTML = `
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-700">
                            ${index + 1}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex rounded-lg bg-[#527b5d] px-3 py-1.5 text-sm font-bold text-white">
                                ${p.nomor}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            ${p.burung}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex rounded-full bg-[#E6F2DD] px-3 py-1 text-sm font-bold text-[#24482f]">
                                ${p.suara} suara
                            </span>
                        </td>
                    `;

                    rekap.appendChild(baris);
                });

                // Tampilkan enam peringkat teratas sebagai daftar jawara.
                hasil.slice(0, 6).forEach(function (p, index) {
                    const baris = document.createElement('tr');
                    baris.className = 'hover:bg-[#f8faf9]';

                    baris.innerHTML = `
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg ${
                                index === 0
                                    ? 'bg-amber-100 text-amber-700'
                                    : 'bg-gray-100 text-gray-700'
                            } text-sm font-bold">
                                ${index + 1}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-700">
                            ${p.nomor}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            ${p.burung}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            ${p.pemilik}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-[#527b5d]">
                            ${p.suara}
                        </td>
                    `;

                    jawara.appendChild(baris);
                });
            }

            selects.forEach(function (select) {
                select.addEventListener('change', hitungSuara);
            });

            hitungSuara();
        });
    </script>
</x-app-layout>