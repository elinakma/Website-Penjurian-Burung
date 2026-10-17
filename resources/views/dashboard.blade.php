<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->role->name === 'admin')
                Dashboard Admin
            @elseif(auth()->user()->role->name === 'juri')
                Dashboard Juri
            @else
                Dashboard Peserta
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ==================== ADMIN ==================== --}}
                    @if(auth()->user()->role->name === 'admin')
                        <h3 class="text-lg font-bold mb-4">Selamat datang, {{ auth()->user()->name }} (Admin)</h3>
                        <p>Ini adalah halaman khusus Admin.</p>
                        {{-- Tambahkan konten admin di sini --}}

                    {{-- ==================== JURI ==================== --}}
                    @elseif(auth()->user()->role->name === 'juri')
                        <h3 class="text-lg font-bold mb-4">Selamat datang, {{ auth()->user()->name }} (Juri)</h3>
                        <p>Ini adalah halaman khusus Juri.</p>
                        {{-- Tambahkan konten juri di sini --}}

                    {{-- ==================== PESERTA ==================== --}}
                    @else
                        <h3 class="text-lg font-bold mb-4">Selamat datang, {{ auth()->user()->name }} (Peserta)</h3>
                        <p>Ini adalah halaman khusus Peserta.</p>
                        {{-- Tambahkan konten peserta di sini --}}
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>