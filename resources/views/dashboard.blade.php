<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 shadow-sm" style="background: linear-gradient(90deg, #E6F2DD 0%, #527b5d 100%);">
            <div>
                <h1 class="text-2xl font-bold text-[#0e1e17]">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang, <span class="font-medium text-[#527b5d]">{{ Auth::user()->name }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        {{-- Card contoh --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#e8f0eb] flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#527b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Acara</p>
                    <p class="text-2xl font-bold text-[#0e1e17]">12</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>