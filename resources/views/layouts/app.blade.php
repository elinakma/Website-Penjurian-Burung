
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lomba Burung') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #527b5d;
            --primary-hover: #456a4f;
            --page-bg: #f6fffd;
            --border-color: rgba(82, 123, 93, 0.14);
        }

        html, body {
            min-height: 100%;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--page-bg);
            color: #26352b;
        }

        /* Navbar */
        .nav-top {
            background: #f6fffd;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-brand {
            color: var(--primary);
        }

        .nav-icon-button {
            color: var(--primary);
            transition: all 0.2s ease;
        }

        .nav-icon-button:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .nav-user-button {
            color: var(--primary);
            transition: all 0.2s ease;
        }

        .nav-user-button:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .nav-user-button:hover .nav-avatar {
            background: #ffffff;
            color: var(--primary);
        }

        .nav-avatar {
            background: var(--primary);
            color: #ffffff;
            transition: all 0.2s ease;
        }

        /* Sidebar */
        .sidebar-bg {
            background: #f6fffd;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 11px 14px;
            margin-bottom: 5px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition:
                background-color 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
        }

        .sidebar-link svg {
            flex-shrink: 0;
            color: inherit;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .sidebar-link.active {
            font-weight: 600;
        }

        .sidebar-link:hover svg,
        .sidebar-link.active svg {
            color: #ffffff;
        }

        .sidebar-heading {
            padding: 20px 12px 8px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .sidebar-divider {
            border-color: var(--border-color);
        }

        .sidebar-user-name {
            color: var(--primary);
        }

        .sidebar-user-role {
            color: #718575;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(82, 123, 93, 0.25);
            border-radius: 10px;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(82, 123, 93, 0.25) transparent;
        }

        /* Main content */
        .main-content {
            background: var(--page-bg);
        }

        .fade-in {
            animation: fadeIn 0.35s ease both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .fade-in {
                animation: none;
            }

            .sidebar-link,
            .nav-icon-button,
            .nav-user-button {
                transition: none;
            }
        }

        .ts-wrapper.multi .ts-control {
            border-radius: 0.5rem;
            border-color: #e5e7eb;
            padding: 0.4rem 0.5rem;
            font-size: 0.875rem;
            min-height: 42px;
        }
        .ts-wrapper.multi .ts-control:focus,
        .ts-wrapper.focus .ts-control {
            border-color: #527b5d !important;
            box-shadow: 0 0 0 1px #527b5d !important;
        }
        .ts-dropdown {
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen flex flex-col"
         x-data="{ sidebarOpen: false }">

        {{-- NAVBAR --}}
        <header class="nav-top sticky top-0 z-50 h-14 flex-shrink-0">
            <div class="flex items-center justify-between h-full px-4 sm:px-6">

                {{-- Kiri: Tombol menu dan nama aplikasi --}}
                <div class="flex items-center gap-3">

                    <button
                        type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="nav-icon-button lg:hidden p-2 rounded-lg"
                        aria-label="Buka navigasi">

                        <svg class="w-6 h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <a href="{{ route('dashboard') }}"
                       class="nav-brand flex items-center gap-2.5">

                        <div class="w-8 h-8 rounded-lg bg-[#527b5d]
                                    flex items-center justify-center">

                            <svg class="w-5 h-5 text-white"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>

                        <span class="font-bold text-base sm:text-lg tracking-tight">
                            {{ config('app.name', 'Lomba Burung') }}
                        </span>
                    </a>
                </div>

                {{-- Kanan: Role dan profil pengguna --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    <div class="hidden sm:flex items-center gap-2
                                text-[#527b5d] text-xs sm:text-sm">

                        <span class="w-2 h-2 rounded-full bg-[#527b5d]"></span>

                        <span class="capitalize">
                            {{ auth()->user()->role->name ?? 'User' }}
                        </span>
                    </div>

                    <x-dropdown align="right" width="48">

                        <x-slot name="trigger">
                            <button
                                type="button"
                                class="nav-user-button flex items-center gap-2
                                       px-2 sm:px-3 py-1.5 rounded-lg
                                       focus:outline-none">

                                <div class="nav-avatar w-8 h-8 rounded-full
                                            flex items-center justify-center
                                            font-semibold text-sm">

                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>

                                <span class="hidden md:block text-sm font-medium">
                                    {{ auth()->user()->name }}
                                </span>

                                <svg class="w-4 h-4"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <x-dropdown-link
                                :href="route('profile.edit')"
                                class="flex items-center gap-2">

                                <svg class="w-4 h-4 text-[#527b5d]"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>

                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2
                                           text-sm text-red-600
                                           hover:bg-red-50 flex items-center gap-2">

                                    <svg class="w-4 h-4"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>

                                    {{ __('Log Out') }}
                                </button>
                            </form>

                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </header>

        {{-- BODY: SIDEBAR DAN CONTENT --}}
        <div class="flex flex-1 min-h-0">

            {{-- Sidebar tetap berada pada file terpisah --}}
            @include('layouts.sidebar')

            {{-- Overlay untuk sidebar mobile --}}
            <div
                x-cloak
                x-show="sidebarOpen"
                @click="sidebarOpen = false"
                x-transition:enter="transition-opacity ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-30 bg-black/30 lg:hidden"
                style="display: none;">
            </div>

            {{-- Main content --}}
            <main class="main-content flex-1 min-w-0 min-h-screen
                         overflow-y-auto fade-in">

                <div class="p-4 sm:p-6 lg:p-8">

                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset

                    {{ $slot }}

                </div>
            </main>
        </div>
    </div>

</body>
</html>
