<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 shadow-sm sm:p-8"
             style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">
                        Manajemen Kelas Lomba
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola kelas perlombaan dalam satu acara.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="#form-tambah-kelas"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kelas
                    </a>

                    <a href="{{ route('kelas-lomba.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0e1e17] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[#243c30]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="mx-auto w-full space-y-6">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Ringkasan error validasi --}}
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Terdapat data yang perlu diperbaiki:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Informasi Acara --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#0e1e17]">Informasi Acara</h2>
                            <p class="text-sm text-gray-500">Acara tempat kelas-kelas ini diselenggarakan.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 lg:grid-cols-4 sm:px-8">
                    <div>
                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Nama Acara</p>
                        <p class="font-semibold text-gray-800">{{ $acara->nama }}</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Tanggal</p>
                        <p class="font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Lokasi</p>
                        <p class="font-medium text-gray-700">{{ $acara->lokasi }}</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Status Acara</p>
                        @php
                            $statusAcara = strtolower($acara->status);
                            $kelasStatusAcara = match ($statusAcara) {
                                'berlangsung' => 'bg-blue-100 text-blue-700',
                                'selesai' => 'bg-gray-100 text-gray-600',
                                default => 'bg-amber-100 text-amber-700',
                            };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $kelasStatusAcara }}">
                            {{ $acara->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Kelas</p>
                            <p class="mt-2 text-2xl font-bold text-[#0e1e17]">{{ $kelasLombas->total() }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E6F2DD] text-[#527b5d]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15l-3.5 2 1-4-3-2.5 4-.3L12 6l1.5 4.2 4 .3-3 2.5 1 4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Kelas Pendaftaran</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-700">
                        {{ $kelasLombas->getCollection()->where('status', 'pendaftaran')->count() }}
                    </p>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Kelas Selesai</p>
                    <p class="mt-2 text-2xl font-bold text-gray-600">
                        {{ $kelasLombas->getCollection()->where('status', 'selesai')->count() }}
                    </p>
                </div>
            </div>

            {{-- Tabel Kelas Lomba yang sudah ada --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <h2 class="text-lg font-bold text-[#0e1e17]">Daftar Kelas Lomba</h2>
                        <p class="mt-1 text-sm text-gray-500">Daftar kelas yang terdaftar pada acara ini.</p>
                    </div>
                    <span class="text-sm text-gray-500">{{ $kelasLombas->total() }} kelas terdaftar</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] table-fixed divide-y divide-gray-100">
                        <colgroup>
                            <col class="w-[5%]">
                            <col class="w-[18%]">
                            <col class="w-[16%]">
                            <col class="w-[12%]">
                            <col class="w-[9%]">
                            <col class="w-[18%]">   {{-- Juri --}}
                            <col class="w-[13%]">
                            <col class="w-[9%]">
                        </colgroup>

                        <thead class="bg-[#527b5d]/15 border-b border-[#527b5d]/25">
                            <tr>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">No</th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Nama Kelas <span class="text-red-500">*</span></th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Jenis Burung <span class="text-red-500">*</span></th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Harga (Rp) <span class="text-red-500">*</span></th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Kuota <span class="text-red-500">*</span></th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Juri</th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Jadwal Final</th>
                                <th class="px-3 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($kelasLombas as $index => $kelasLomba)
                                <tr class="transition hover:bg-gray-50/80">
                                    <td class="px-3 py-4 text-center text-sm text-gray-500">
                                        {{ $kelasLombas->firstItem() + $index }}
                                    </td>

                                    <td class="break-words px-3 py-4 text-sm text-center">
                                        <p class="font-semibold text-gray-800">{{ $kelasLomba->nama }}</p>
                                    </td>

                                    <td class="break-words px-3 py-4 text-sm text-gray-600 text-center">
                                        {{ $kelasLomba->burung->nama ?? '-' }}
                                    </td>

                                    <td class="px-3 py-4 text-center text-sm font-medium text-gray-700">
                                        Rp{{ number_format($kelasLomba->harga, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 py-4 text-center text-sm text-gray-600 text-center">
                                        {{ number_format($kelasLomba->kuota, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 py-4 text-sm text-gray-600">
                                        @if ($kelasLomba->juris->isNotEmpty())
                                            {{ $kelasLomba->juris->pluck('name')->implode(', ') }}
                                        @else
                                            <span class="text-gray-400">Belum ada juri</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-4 text-center text-sm text-gray-600">
                                        @if ($kelasLomba->final_at)
                                            {{ \Carbon\Carbon::parse($kelasLomba->final_at)->translatedFormat('d M Y, H:i') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kelas-lomba.edit', $kelasLomba->id_kelas) }}"
                                            title="Edit kelas"
                                            class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('kelas-lomba.destroy', $kelasLomba->id_kelas) }}"
                                                method="POST" class="form-hapus-kelas">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" title="Hapus kelas"
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
                                    <td colspan="7" class="px-6 py-14 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 font-semibold text-gray-800">Belum Ada Kelas Lomba</h3>
                                        <p class="mt-1 text-sm text-gray-500">Tambahkan kelas lomba pertama untuk acara ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($kelasLombas->hasPages())
                    <div class="border-t border-gray-100 px-6 py-4 sm:px-8">
                        {{ $kelasLombas->links() }}
                    </div>
                @endif
            </div>

            {{-- ==================== FORM TAMBAH BANYAK KELAS ==================== --}}
            <div id="form-tambah-kelas" class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                    <h2 class="text-lg font-bold text-[#0e1e17]">Tambah Kelas Lomba</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan beberapa kelas sekaligus. Klik tombol <strong>+ Tambah Kelas</strong> untuk menambah baris baru.
                    </p>
                </div>

                <form id="form-kelas-lomba-bulk"
                    action="{{ route('kelas-lomba.store') }}"
                    method="POST"
                    class="p-6 sm:p-8">
                    @csrf
                    <input type="hidden" name="acara_id" value="{{ $acara->id_acara }}">

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1200px] table-fixed" id="tabel-tambah-kelas">
                            <colgroup>
                                <col class="w-[5%]">
                                <col class="w-[18%]">
                                <col class="w-[15%]">
                                <col class="w-[12%]">
                                <col class="w-[9%]">
                                <col class="w-[20%]">
                                <col class="w-[13%]">
                                <col class="w-[8%]">
                            </colgroup>

                            <thead>
                                <tr class="border-b border-gray-200 text-xs font-bold uppercase tracking-wider text-gray-500">
                                    <th class="px-3 py-3 text-center">No</th>
                                    <th class="px-3 py-3 text-left">Nama Kelas <span class="text-red-500">*</span></th>
                                    <th class="px-3 py-3 text-left">Jenis Burung <span class="text-red-500">*</span></th>
                                    <th class="px-3 py-3 text-right">Harga (Rp) <span class="text-red-500">*</span></th>
                                    <th class="px-3 py-3 text-center">Kuota <span class="text-red-500">*</span></th>
                                    <th class="px-3 py-3 text-left">Juri</th>
                                    <th class="px-3 py-3 text-center">Jadwal Final</th>
                                    <th class="px-3 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="baris-kelas">
                                {{-- Diisi oleh JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-6 flex flex-col-reverse items-stretch justify-between gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center">
                        <button type="button" id="btn-tambah-baris"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#527b5d] bg-white px-5 py-2.5 text-sm font-semibold text-[#527b5d] transition hover:bg-[#E6F2DD]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kelas
                        </button>

                        <div class="flex flex-col-reverse gap-3 sm:flex-row">
                            <button type="button" id="btn-reset-form"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                Reset
                            </button>
                            <button type="button" id="btn-simpan-semua"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-6 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d] active:scale-[0.98]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Semua
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div id="modal-hapus-kelas"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v4m0 4h.01M10.3 3.9L2.7 17a2 2 0 001.7 3h15.2a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
            </div>
            <p class="mb-6 text-sm text-gray-600">
                Apakah kamu yakin ingin menghapus kelas lomba ini? Data yang telah dihapus tidak dapat dikembalikan.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="batal-hapus-kelas"
                        class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" id="konfirmasi-hapus-kelas"
                        class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- Modal konfirmasi simpan bulk --}}
    <div id="modal-konfirmasi-simpan"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Simpan</h3>
            </div>
            <p class="mb-6 text-sm text-gray-600">
                Apakah kamu yakin ingin menyimpan <span id="jumlah-kelas-simpan" class="font-semibold">0</span> kelas lomba ini?
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="batal-simpan-bulk"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Periksa Kembali
                </button>
                <button type="button" id="konfirmasi-simpan-bulk"
                        class="rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const burungs = @json($burungs ?? []);
            const juris   = @json($juris ?? []);

            const tbody          = document.getElementById('baris-kelas');
            const btnTambahBaris = document.getElementById('btn-tambah-baris');
            const btnReset       = document.getElementById('btn-reset-form');
            const btnSimpanSemua = document.getElementById('btn-simpan-semua');
            const form           = document.getElementById('form-kelas-lomba-bulk');

            let rowIndex = 0;
            const tomSelectInstances = {};

            function buatOpsiBurung() {
                let html = '<option value="">Pilih jenis burung</option>';
                burungs.forEach(b => {
                    html += `<option value="${b.id}">${b.nama}</option>`;
                });
                return html;
            }

            function buatOpsiJuri() {
                let html = '';
                juris.forEach(j => {
                    html += `<option value="${j.id}">${j.name}</option>`;
                });
                return html;
            }

            function initTomSelect(selectElement, rowId) {
                if (tomSelectInstances[rowId]) {
                    tomSelectInstances[rowId].destroy();
                }

                tomSelectInstances[rowId] = new TomSelect(selectElement, {
                    plugins: ['remove_button'],
                    maxItems: null,
                    placeholder: 'Ketik nama juri...',
                    searchField: ['text'],
                    create: false,
                    sortField: { field: 'text', direction: 'asc' },
                    render: {
                        no_results: function() {
                            return '<div class="no-results px-3 py-2 text-sm text-gray-500">Juri tidak ditemukan</div>';
                        }
                    }
                });
            }

            function tambahBaris() {
                rowIndex++;
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-100 hover:bg-gray-50/50';
                tr.dataset.index = rowIndex;

                const selectId = `juri-select-${rowIndex}`;

                tr.innerHTML = `
                    <td class="px-3 py-3 text-center text-sm text-gray-500 nomor-baris">${rowIndex}</td>

                    <td class="px-3 py-3">
                        <input type="text" name="kelas[${rowIndex}][nama]" required maxlength="255"
                            placeholder="Contoh: Murai Batu - Kelas Utama"
                            class="w-full min-w-0 rounded-lg border-gray-200 px-2 py-2 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </td>

                    <td class="px-3 py-3">
                        <select name="kelas[${rowIndex}][burung_id]" required
                                class="w-full min-w-0 rounded-lg border-gray-200 px-2 py-2 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                            ${buatOpsiBurung()}
                        </select>
                    </td>

                    <td class="px-3 py-3">
                        <input type="number" name="kelas[${rowIndex}][harga]" required min="0" step="1" placeholder="150000"
                            class="w-full min-w-0 rounded-lg border-gray-200 px-2 py-2 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </td>

                    <td class="px-3 py-3">
                        <input type="number" name="kelas[${rowIndex}][kuota]" required min="1" step="1" placeholder="50"
                            class="w-full min-w-0 rounded-lg border-gray-200 px-2 py-2 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </td>

                    <td class="px-3 py-3">
                        <select id="${selectId}" name="kelas[${rowIndex}][juri_ids][]" multiple
                                placeholder="Ketik nama juri...">
                            ${buatOpsiJuri()}
                        </select>
                    </td>

                    <td class="px-3 py-3">
                        <input type="datetime-local" name="kelas[${rowIndex}][final_at]"
                            class="w-full min-w-0 rounded-lg border-gray-200 px-2 py-2 text-xs focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </td>

                    <td class="px-3 py-3 text-center">
                        <button type="button" class="btn-hapus-baris inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100" title="Hapus baris">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
                updateNomor();

                // Inisialisasi Tom Select
                const selectEl = document.getElementById(selectId);
                initTomSelect(selectEl, rowIndex);
            }

            function updateNomor() {
                tbody.querySelectorAll('tr').forEach((row, idx) => {
                    row.querySelector('.nomor-baris').textContent = idx + 1;
                });
            }

            // Hapus baris
            tbody.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-hapus-baris');
                if (!btn) return;

                const row = btn.closest('tr');
                const index = row.dataset.index;

                if (tbody.querySelectorAll('tr').length > 1) {
                    if (tomSelectInstances[index]) {
                        tomSelectInstances[index].destroy();
                        delete tomSelectInstances[index];
                    }
                    row.remove();
                    updateNomor();
                } else {
                    row.querySelectorAll('input').forEach(el => el.value = '');
                    row.querySelectorAll('select').forEach(el => {
                        if (el.multiple && tomSelectInstances[index]) {
                            tomSelectInstances[index].clear();
                        } else {
                            el.selectedIndex = 0;
                        }
                    });
                }
            });

            btnTambahBaris.addEventListener('click', tambahBaris);

            btnReset.addEventListener('click', function () {
                Object.values(tomSelectInstances).forEach(ts => ts.destroy());
                for (let key in tomSelectInstances) delete tomSelectInstances[key];

                tbody.innerHTML = '';
                rowIndex = 0;
                tambahBaris();
            });

            // Mulai dengan 1 baris
            tambahBaris();

            // ==================== MODAL HAPUS ====================
            const modalHapus = document.getElementById('modal-hapus-kelas');
            const tombolBatalHapus = document.getElementById('batal-hapus-kelas');
            const tombolKonfirmasiHapus = document.getElementById('konfirmasi-hapus-kelas');
            let formAktifHapus = null;

            document.querySelectorAll('.btn-hapus-kelas').forEach(function (tombol) {
                tombol.addEventListener('click', function () {
                    formAktifHapus = tombol.closest('.form-hapus-kelas');
                    modalHapus.classList.remove('hidden');
                    modalHapus.classList.add('flex');
                });
            });

            function tutupModalHapus() {
                modalHapus.classList.add('hidden');
                modalHapus.classList.remove('flex');
                formAktifHapus = null;
            }

            tombolBatalHapus.addEventListener('click', tutupModalHapus);
            modalHapus.addEventListener('click', function (e) {
                if (e.target === modalHapus) tutupModalHapus();
            });
            tombolKonfirmasiHapus.addEventListener('click', function () {
                if (formAktifHapus) formAktifHapus.submit();
            });

            // ==================== MODAL SIMPAN BULK ====================
            const modalSimpan = document.getElementById('modal-konfirmasi-simpan');
            const jumlahKelasSpan = document.getElementById('jumlah-kelas-simpan');
            const batalSimpan = document.getElementById('batal-simpan-bulk');
            const konfirmasiSimpan = document.getElementById('konfirmasi-simpan-bulk');

            btnSimpanSemua.addEventListener('click', function () {
                // Validasi HTML5
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const jumlah = tbody.querySelectorAll('tr').length;
                jumlahKelasSpan.textContent = jumlah;

                modalSimpan.classList.remove('hidden');
                modalSimpan.classList.add('flex');
            });

            function tutupModalSimpan() {
                modalSimpan.classList.add('hidden');
                modalSimpan.classList.remove('flex');
            }

            batalSimpan.addEventListener('click', tutupModalSimpan);
            modalSimpan.addEventListener('click', function (e) {
                if (e.target === modalSimpan) tutupModalSimpan();
            });

            konfirmasiSimpan.addEventListener('click', function () {
                konfirmasiSimpan.disabled = true;
                konfirmasiSimpan.textContent = 'Menyimpan...';
                form.submit();
            });
        });
    </script>
</x-app-layout>