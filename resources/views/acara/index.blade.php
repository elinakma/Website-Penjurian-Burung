<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                {{-- Bagian Kiri: Judul dan Deskripsi --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Manajemen Acara</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola jadwal acara perlombaan.</p>
                </div>

                {{-- Bagian Kanan: Tombol Tambah Acara (HANYA ADMIN) --}}
                @if(auth()->user()->role?->name === 'admin')
                    <div class="flex shrink-0">
                        <a href="{{ route('acara.create') }}"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-green shadow-md transition hover:bg-gray-50 active:scale-[0.98]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Acara
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Flash message --}}
        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filter --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <form action="{{ route('acara.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {{-- Cari --}}
                    <div>
                        <label for="search" class="mb-1.5 block text-sm font-semibold text-gray-700">Cari Acara</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2" d="m16 16 4 4"/>
                            </svg>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama atau lokasi..."
                                   class="w-full rounded-xl border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-semibold text-gray-700">Status Acara</label>
                        <select id="status" name="status"
                                class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                            <option value="">Semua Status</option>
                            <option value="Belum Mulai" @selected(request('status') === 'Belum Mulai')>Belum Mulai</option>
                            <option value="Berlangsung" @selected(request('status') === 'Berlangsung')>Berlangsung</option>
                            <option value="Selesai" @selected(request('status') === 'Selesai')>Selesai</option>
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <label for="tanggal_mulai" class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                               class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </div>

                    {{-- Tanggal Akhir --}}
                    <div>
                        <label for="tanggal_akhir" class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                               class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 8v6l-4 2v-8L3 4z"/>
                        </svg>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('acara.index') }}"
                       class="inline-flex items-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="font-bold text-gray-800">Daftar Acara</h2>
                <p class="text-sm text-gray-500">Total: {{ $acaras->total() }} acara</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left">
                    <thead class="bg-[#527b5d]/15 border-b border-[#527b5d]/25">
                        <tr>
                            <th class="w-16 px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">No</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Nama Acara</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Tanggal</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Lokasi</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Status</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Mulai Acara</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($acaras as $index => $acara)
                            <tr class="transition-colors hover:bg-[#f8faf9]">

                                {{-- No --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ $acaras->firstItem() + $index }}
                                    </span>
                                </td>

                                {{-- Nama --}}
                                <td class="px-6 py-4 text-left text-sm text-gray-700">
                                    <p class="font-semibold text-gray-800">{{ $acara->nama }}</p>
                                </td>

                                {{-- Tanggal --}}
                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-2 text-sm text-gray-700">
                                        <svg class="h-4 w-4 shrink-0 text-[#527b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $acara->tanggal->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- Lokasi --}}
                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-2 text-sm text-gray-700">
                                        <svg class="h-4 w-4 shrink-0 text-[#527b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="max-w-[160px] truncate">{{ $acara->lokasi }}</span>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $statusClass = match($acara->status) {
                                            'Berlangsung' => 'bg-emerald-100 text-emerald-800',
                                            'Belum Mulai' => 'bg-amber-100 text-amber-800',
                                            'Selesai'     => 'bg-gray-100 text-gray-600',
                                            default       => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center justify-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $acara->status }}
                                    </span>
                                </td>

                                {{-- ===== KOLOM MULAI ACARA ===== --}}
                                <td class="px-4 py-4 text-center">
                                    @if($acara->kelas_lombas_count === 0)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Belum ada kelas lomba
                                        </span>
                                    @elseif($acara->status === 'Belum Mulai')
                                        {{-- Tombol Mulai hanya untuk ADMIN --}}
                                        @if(auth()->user()->role?->name === 'admin')
                                            <form action="{{ route('acara.mulai', $acara) }}" method="POST"
                                                  onsubmit="return confirm('Yakin mulai acara ini? Data akan dikirim ke juri & peserta.')">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-700 active:scale-[0.98]">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Mulai Acara
                                                </button>
                                            </form>
                                        @else
                                            {{-- Juri: hanya tampil teks --}}
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                                Belum dimulai
                                            </span>
                                        @endif
                                    @elseif($acara->status === 'Berlangsung')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current animate-pulse"></span>
                                            Sedang Berlangsung
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Sudah Selesai
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Detail: tampil untuk SEMUA role --}}
                                        <a href="{{ route('acara.show', $acara) }}"
                                           class="rounded-lg bg-[#527b5d] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#42684d]">
                                            Detail
                                        </a>

                                        {{-- Edit & Hapus: HANYA ADMIN --}}
                                        @if(auth()->user()->role?->name === 'admin')
                                            <a href="{{ route('acara.edit', $acara) }}"
                                               class="rounded-lg bg-gray-100 p-2 text-gray-600 transition hover:bg-gray-200"
                                               title="Edit">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('acara.destroy', $acara) }}" method="POST"
                                                  onsubmit="return confirm('Yakin hapus acara ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="rounded-lg bg-gray-100 p-2 text-red-500 transition hover:bg-red-50"
                                                        title="Hapus">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <p class="text-gray-500">Tidak ada acara yang sesuai dengan filter.</p>
                                        @if(auth()->user()->role?->name === 'admin')
                                            <a href="{{ route('acara.create') }}"
                                               class="font-semibold text-[#527b5d] hover:underline">
                                                Tambah acara pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($acaras->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">
                    {{ $acaras->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>