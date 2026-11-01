<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl px-6 py-4 sm:px-8 sm:py-5 shadow-sm"
        style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <h1 class="text-2xl font-bold text-[#0e1e17]">Edit Profil</h1>
            <p class="text-sm text-gray-600 mt-1">
                Perbarui informasi akun Anda.
            </p>
        </div>
    </x-slot>

    <div class="pt-0 pb-5">
        <div class="w-full mx-auto max-w-3xl">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="name" id="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                            required>

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor Telepon / WhatsApp <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                            required>

                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>

                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]"
                            required>

                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-base font-bold text-gray-800">
                            Ubah Password
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Kosongkan bagian ini jika tidak ingin mengganti password.
                        </p>
                    </div>

                    {{-- Password Lama --}}
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password Lama
                        </label>

                        <input type="password" name="current_password" id="current_password"
                            autocomplete="current-password"
                            placeholder="Masukkan password lama"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">

                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password Baru
                        </label>

                        <input type="password" name="password" id="password"
                            autocomplete="new-password"
                            placeholder="Masukkan password baru"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">

                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Konfirmasi Password Baru
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation"
                            autocomplete="new-password"
                            placeholder="Ulangi password baru"
                            class="w-full rounded-xl border-gray-200 px-4 py-2.5 text-sm focus:border-[#527b5d] focus:ring-[#527b5d]">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="submit"
                            class="inline-flex items-center rounded-xl bg-[#527b5d] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#42684d]">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
