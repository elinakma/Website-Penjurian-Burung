<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 shadow-sm sm:p-8"
             style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#0e1e17]">Tambah Pengguna</h1>
                    <p class="mt-1 text-sm text-gray-600">Isi data pengguna baru.</p>
                </div>

                <a href="{{ route('users.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#527b5d] shadow-md transition hover:bg-gray-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl">

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Terdapat data yang perlu diperbaiki:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6 p-6 sm:p-8">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label for="phone" class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Nomor Telepon
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] @error('phone') border-red-400 @enderror">
                        @error('phone')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role_id" class="mb-1.5 block text-sm font-semibold text-gray-700">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role_id" id="role_id" required
                                class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] @error('role_id') border-red-400 @enderror">
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-700">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" required
                                   class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d] @error('password') border-red-400 @enderror">
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-gray-700">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full rounded-xl border-gray-200 px-3 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-100 pt-5 sm:flex-row">
                        <a href="{{ route('users.index') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#527b5d] px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#42684d]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>