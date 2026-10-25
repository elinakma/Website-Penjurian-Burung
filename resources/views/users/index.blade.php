
<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm"
            style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                {{-- Bagian Kiri: Judul dan Deskripsi --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Manajemen Pengguna</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola data pengguna sistem.
                    </p>
                </div>

                {{-- Bagian Kanan: Tombol Tambah Pengguna --}}
                <div class="flex shrink-0">
                    <a href="{{ route('users.create') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Pengguna
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filter Pengguna --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <form action="{{ route('users.index') }}" method="GET" class="space-y-4">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-2">

                    {{-- Cari Pengguna --}}
                    <div>
                        <label for="search"
                            class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Cari Pengguna
                        </label>

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" stroke-width="2" />
                                <path stroke-linecap="round" stroke-width="2" d="m16 16 4 4" />
                            </svg>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Nama, email, atau telepon..."
                                class="w-full rounded-xl border-gray-200 py-2.5 pl-9 pr-3 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                            >
                        </div>
                    </div>

                    {{-- Filter Role --}}
                    <div>
                        <label for="role_id"
                            class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Filter Role
                        </label>

                        <select
                            id="role_id"
                            name="role_id"
                            class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                        >
                            <option value="">Semua Role</option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->id }}"
                                    @selected(request('role_id') == $role->id)
                                >
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Filter dan Reset --}}
                    <div class="flex flex-wrap items-center gap-3 pt-1 md:col-span-2">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#42684d] active:scale-[0.98]"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h18l-7 8v6l-4 2v-8L3 4z" />
                            </svg>
                            Terapkan Filter
                        </button>

                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel Pengguna --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            {{-- Header Tabel --}}
            <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="font-bold text-gray-800">
                    Daftar Pengguna
                </h2>

                <p class="text-sm text-gray-500">
                    Total: {{ $users->total() }} pengguna
                </p>
            </div>

            {{-- Tabel Responsif --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">

                    <thead class="border-b border-[#527b5d]/25 bg-[#527b5d]/15">
                        <tr>
                            <th class="w-16 px-4 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">No</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Nama</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Email</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Telepon</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Peran</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-[#24482f]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $index => $user)
                            <tr class="transition-colors hover:bg-[#f8faf9]">

                                {{-- Nomor --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ $users->firstItem() + $index }}
                                    </span>
                                </td>

                                {{-- Nama Pengguna --}}
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <p class="break-words font-semibold text-gray-800">
                                        {{ $user->name }}
                                    </p>
                                </td>

                                {{-- Email --}}
                                <td class="break-words px-6 py-4 text-sm text-gray-600 text-center">
                                    {{ $user->email }}
                                </td>

                                {{-- Telepon --}}
                                <td class="break-words px-6 py-4 text-sm text-gray-600 text-center">
                                    {{ $user->phone ?? '-' }}
                                </td>

                                {{-- Role --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex max-w-full items-center rounded-full bg-[#E6F2DD] px-3 py-1.5 text-xs font-semibold text-[#527b5d]">
                                        {{ $user->role->name ?? 'Tidak ada role' }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">

                                        {{-- Edit --}}
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="rounded-lg bg-gray-100 p-2 text-gray-600 transition hover:bg-gray-200"
                                            title="Edit pengguna"
                                            aria-label="Edit pengguna {{ $user->name }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Hapus: tidak ditampilkan untuk akun sendiri --}}
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-lg bg-gray-100 p-2 text-red-500 transition hover:bg-red-50"
                                                    title="Hapus pengguna"
                                                    aria-label="Hapus pengguna {{ $user->name }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-gray-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M12 7a4 4 0 11-8 0 4 4 0 018 0zm8 4a4 4 0 100-8" />
                                        </svg>

                                        <p class="text-gray-500">
                                            Tidak ada pengguna yang sesuai dengan filter.
                                        </p>

                                        <a href="{{ route('users.create') }}"
                                            class="font-semibold text-[#527b5d] hover:underline">
                                            Tambah pengguna pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
