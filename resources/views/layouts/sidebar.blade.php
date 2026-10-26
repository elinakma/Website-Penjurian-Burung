
{{-- ==================== DESKTOP SIDEBAR ==================== --}}
<aside
    class="hidden lg:flex flex-col flex-shrink-0
           w-[240px] xl:w-[260px]
           sidebar-bg border-r border-[#527b5d]/10">

    {{-- Menu navigasi --}}
    <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>

            Dashboard
        </a>

        {{-- ==================== MENU ADMIN ==================== --}}
        @if(auth()->user()->role->name === 'admin')

            <div class="sidebar-heading">
                Manajemen Lomba
            </div>

            <a href="{{ route('acara.index') }}"
               class="sidebar-link {{ request()->routeIs('acara.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>

                Manajemen Acara
            </a>

            <a href="{{ route('kelas-lomba.index') }}"
               class="sidebar-link {{ request()->routeIs('kelas-lomba.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>

                Kelas Lomba
            </a>

            <a href="{{ route('burung.index') }}"
               class="sidebar-link {{ request()->routeIs('burung.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>

                Jenis Burung
            </a>

            <div class="sidebar-heading">
                Manajemen Sistem
            </div>

            <a href="{{ route('users.index') }}"
               class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>

                Data Pengguna
            </a>

            <div class="sidebar-heading">
                Operasional Lomba
            </div>

            <a href="{{ route('pembayaran.index') }}"
               class="sidebar-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>

                Pembayaran
            </a>

            <a href="#"
               class="sidebar-link">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>

                Penilaian
            </a>

        @endif

        {{-- ==================== MENU JURI ==================== --}}
        @if(auth()->user()->role->name === 'juri')

            <div class="sidebar-heading">
                Menu Juri
            </div>

            <a href="{{ route('acara.index') }}"
               class="sidebar-link {{ request()->routeIs('acara.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>

                Acara
            </a>

            <a href="{{ route('penilaian.index') }}"
               class="sidebar-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>

                Penilaian
            </a>

        @endif

    </nav>

    {{-- Informasi pengguna di bagian bawah sidebar --}}
    <div class="sidebar-divider border-t p-4">
        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-full bg-[#527b5d]
                        flex items-center justify-center
                        text-white font-semibold flex-shrink-0">

                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="sidebar-user-name text-sm font-semibold truncate">
                    {{ auth()->user()->name }}
                </p>

                <p class="sidebar-user-role text-xs capitalize font-medium">
                    {{ auth()->user()->role->name ?? '-' }}
                </p>
            </div>

        </div>
    </div>
</aside>


{{-- ==================== MOBILE SIDEBAR ==================== --}}
<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-14 left-0 bottom-0 z-40
           w-[260px] max-w-[85vw]
           sidebar-bg border-r border-[#527b5d]/10
           transform transition-transform duration-300 ease-in-out
           lg:hidden flex flex-col shadow-xl">

    {{-- Header mobile --}}
    <div class="sidebar-divider border-b px-5 py-4
                flex items-center justify-between">

        <p class="text-xs font-bold tracking-widest uppercase text-[#527b5d]">
            Navigasi
        </p>

        <button
            type="button"
            @click="sidebarOpen = false"
            class="text-[#527b5d] hover:bg-[#527b5d]
                   hover:text-white p-2 rounded-lg transition"
            aria-label="Tutup navigasi">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Menu mobile --}}
    <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4">

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>

            Dashboard
        </a>

        @if(auth()->user()->role->name === 'admin')

            <div class="sidebar-heading">
                Manajemen Lomba
            </div>

            <a href="{{ route('acara.index') }}"
               class="sidebar-link {{ request()->routeIs('acara.*') ? 'active' : '' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>

                Manajemen Acara
            </a>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Kelas Lomba
            </a>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Jenis Burung
            </a>

            <div class="sidebar-heading">
                Manajemen Sistem
            </div>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Data Pengguna
            </a>

            <div class="sidebar-heading">
                Operasional Lomba
            </div>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Pembayaran
            </a>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Penilaian
            </a>

        @endif

        @if(auth()->user()->role->name === 'juri')

            <div class="sidebar-heading">
                Menu Juri
            </div>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Acara
            </a>

            <a href="#" class="sidebar-link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Penilaian
            </a>

        @endif

    </nav>

    {{-- Informasi pengguna mobile --}}
    <div class="sidebar-divider border-t p-4">
        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-full bg-[#527b5d]
                        flex items-center justify-center
                        text-white font-semibold flex-shrink-0">

                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="sidebar-user-name text-sm font-semibold truncate">
                    {{ auth()->user()->name }}
                </p>

                <p class="sidebar-user-role text-xs capitalize font-medium">
                    {{ auth()->user()->role->name ?? '-' }}
                </p>
            </div>

        </div>
    </div>
</aside>
