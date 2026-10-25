<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Sistem Penjurian Burung</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .register-bg {
            background:
                linear-gradient(180deg, rgba(14, 30, 23, .12), rgba(14, 30, 23, .88)),
                url('https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=1600&q=85');
            background-size: cover;
            background-position: center;
        }

        .form-input {
            transition: all .25s ease;
        }

        .form-input:focus {
            border-color: #527b5d;
            box-shadow: 0 0 0 4px rgba(82, 123, 93, .12);
        }

        .register-button {
            transition: all .25s ease;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(36, 72, 47, .2);
        }

        .register-button:active {
            transform: scale(.99);
        }

        .fade-in {
            animation: fadeIn .7s ease both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#f6f7f3]">

    <main class="grid min-h-screen grid-cols-1 lg:grid-cols-2">

        <!-- LEFT: HERO IMAGE -->
        <section class="register-bg relative hidden min-h-screen flex-col justify-between p-10 text-white lg:flex xl:p-14">

            <div class="absolute inset-0 bg-[#10261b]/10"></div>

            <!-- Brand -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/30 bg-white/15 text-xl backdrop-blur-md">
                    🐦
                </div>

                <div>
                    <p class="text-lg font-bold tracking-wide">BURUNG JUARA</p>
                    <p class="text-xs tracking-[.2em] text-white/75">
                        JUDGING MANAGEMENT SYSTEM
                    </p>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 max-w-xl fade-in">
                <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-2 text-xs font-medium tracking-wider backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    BERGABUNG BERSAMA KAMI
                </span>

                <h1 class="text-4xl font-bold leading-tight xl:text-5xl">
                    Mulai perjalananmu,
                    <span class="text-lime-300">wujudkan kompetisi yang berkualitas.</span>
                </h1>

                <p class="mt-5 max-w-md text-sm leading-7 text-white/80 xl:text-base">
                    Daftarkan akunmu untuk mengakses Sistem Penjurian Burung.
                    Bersama kita wujudkan proses penilaian yang transparan,
                    terstruktur, dan profesional.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <div class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-md">
                        <p class="text-sm font-semibold">Proses Terstruktur</p>
                        <p class="mt-1 text-xs text-white/70">
                            Pengelolaan lebih mudah
                        </p>
                    </div>

                    <div class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-md">
                        <p class="text-sm font-semibold">Kompetisi Transparan</p>
                        <p class="mt-1 text-xs text-white/70">
                            Penilaian lebih terpercaya
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 flex items-center justify-between gap-4 text-xs text-white/65">
                <p>© {{ date('Y') }} Burung Juara</p>
                <p>Fairness · Accuracy · Integrity</p>
            </div>
        </section>

        <!-- RIGHT: REGISTER FORM -->
        <section class="flex min-h-screen items-center justify-center px-5 py-8 sm:px-10 lg:px-12 xl:px-20">

            <div class="w-full max-w-md fade-in">

                <!-- Mobile Brand -->
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e5eee4] text-xl">
                        🐦
                    </div>

                    <div>
                        <p class="font-bold tracking-wide text-[#244a32]">
                            BURUNG JUARA
                        </p>
                        <p class="text-xs tracking-wider text-gray-500">
                            JUDGING MANAGEMENT SYSTEM
                        </p>
                    </div>
                </div>

                <!-- Heading -->
                <div class="mb-7">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e5eee4] text-[#315c3d]">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-7 w-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 20a7 7 0 0114 0M19 8l1.5 1.5L22 7"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-sm font-semibold uppercase tracking-[.18em] text-[#527b5d]">
                        Create Account
                    </p>

                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Buat Akun Baru
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-gray-500">
                        Lengkapi data berikut untuk mendaftar dan mulai menggunakan
                        Sistem Penjurian Burung.
                    </p>
                </div>

                <!-- General Validation Errors -->
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">Pendaftaran belum berhasil.</p>
                        <p class="mt-1">Periksa kembali data yang kamu masukkan.</p>
                    </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">
                            Nama Lengkap
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 20a7 7 0 0114 0"/>
                                </svg>
                            </div>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-4 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >
                        </div>

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                            Email
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7l9 6 9-6"/>
                                </svg>
                            </div>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="nama@email.com"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-4 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >
                        </div>

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="no_telepon" class="mb-2 block text-sm font-semibold text-gray-700">
                            Nomor Telepon
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M5 3h4l2 5-2.5 1.5a14 14 0 006 6L16 13l5 2v4a2 2 0 01-2 2C10 20.5 3.5 14 3 5a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <input
                                id="no_telepon"
                                type="tel"
                                name="no_telepon"
                                value="{{ old('no_telepon') }}"
                                required
                                autocomplete="tel"
                                placeholder="Contoh: 081234567890"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-4 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >
                        </div>

                        @error('no_telepon')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <rect x="4" y="10" width="16" height="11" rx="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 10V7a4 4 0 118 0v3"/>
                                </svg>
                            </div>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Buat password"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-12 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >

                            <button
                                type="button"
                                data-toggle-password="password"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#315c3d]"
                            >
                                <svg data-eye-icon xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <rect x="4" y="10" width="16" height="11" rx="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 10V7a4 4 0 118 0v3"/>
                                </svg>
                            </div>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-12 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >

                            <button
                                type="button"
                                data-toggle-password="password_confirmation"
                                aria-label="Tampilkan konfirmasi password"
                                aria-pressed="false"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#315c3d]"
                            >
                                <svg data-eye-icon xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>

                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="register-button flex w-full items-center justify-center gap-2 rounded-xl bg-[#315c3d] px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-green-900/10 hover:bg-[#244a32] focus:outline-none focus:ring-4 focus:ring-green-900/15"
                    >
                        Daftar Akun

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 12h14m-6-6l6 6-6 6"/>
                        </svg>
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-7 text-center">
                    <p class="text-sm text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                           class="font-bold text-[#315c3d] transition hover:text-[#244a32] hover:underline">
                            Masuk
                        </a>
                    </p>
                </div>

                <!-- Footer -->
                <div class="mt-8 border-t border-gray-200 pt-5 text-center">
                    <p class="text-xs leading-5 text-gray-400">
                        Sistem Penjurian Burung · Platform Pengelolaan Kompetisi
                    </p>
                </div>

            </div>
        </section>
    </main>

    <!-- Toggle Password Visibility -->
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                const inputId = this.dataset.togglePassword;
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = this.querySelector('[data-eye-icon]');

                const isHidden = passwordInput.type === 'password';

                passwordInput.type = isHidden ? 'text' : 'password';

                this.setAttribute('aria-pressed', String(isHidden));
                this.setAttribute(
                    'aria-label',
                    isHidden ? 'Sembunyikan password' : 'Tampilkan password'
                );

                eyeIcon.innerHTML = isHidden
                    ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8M9.9 5.2A10.5 10.5 0 0112 5c6 0 9.5 7 9.5 7a17 17 0 01-3.2 4.1M6.2 6.2C3.9 7.8 2.5 12 2.5 12s3.5 7 9.5 7a9.6 9.6 0 003.3-.6"/>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/><circle cx="12" cy="12" r="3"/>';
            });
        });
    </script>

</body>
</html>