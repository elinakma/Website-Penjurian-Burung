
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Penjurian Burung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .login-bg {
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

        .login-button {
            transition: all .25s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(36, 72, 47, .2);
        }

        .login-button:active {
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

    <main class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <!-- LEFT: HERO IMAGE -->
        <section class="login-bg relative hidden min-h-screen flex-col justify-between p-10 text-white lg:flex xl:p-14">

            <div class="absolute inset-0 bg-[#10261b]/10"></div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/30 bg-white/15 text-xl backdrop-blur-md">
                    🐦
                </div>
                <div>
                    <p class="text-lg font-bold tracking-wide">BURUNG JUARA</p>
                    <p class="text-xs tracking-[.2em] text-white/75">JUDGING MANAGEMENT SYSTEM</p>
                </div>
            </div>

            <div class="relative z-10 max-w-xl fade-in">
                <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-2 text-xs font-medium tracking-wider backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    SISTEM PENJURIAN DIGITAL
                </span>

                <h1 class="text-4xl font-bold leading-tight xl:text-5xl">
                    Menilai dengan objektif,
                    <span class="text-lime-300">menentukan juara dengan integritas.</span>
                </h1>

                <p class="mt-5 max-w-md text-sm leading-7 text-white/80 xl:text-base">
                    Selamat datang di sistem penjurian burung. Kelola proses penilaian,
                    pantau hasil, dan wujudkan kompetisi yang lebih transparan serta profesional.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <div class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-md">
                        <p class="text-sm font-semibold">Penilaian Terstruktur</p>
                        <p class="mt-1 text-xs text-white/70">Lebih rapi dan sistematis</p>
                    </div>
                    <div class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-md">
                        <p class="text-sm font-semibold">Hasil Terintegrasi</p>
                        <p class="mt-1 text-xs text-white/70">Mudah dipantau</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between gap-4 text-xs text-white/65">
                <p>© {{ date('Y') }} Burung Juara</p>
                <p>Fairness · Accuracy · Integrity</p>
            </div>
        </section>


        <!-- RIGHT: LOGIN FORM -->
        <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-20">

            <div class="w-full max-w-md fade-in">

                <!-- Mobile brand -->
                <div class="mb-10 flex items-center gap-3 lg:hidden">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e5eee4] text-xl">
                        🐦
                    </div>
                    <div>
                        <p class="font-bold tracking-wide text-[#244a32]">BURUNG JUARA</p>
                        <p class="text-xs tracking-wider text-gray-500">JUDGING MANAGEMENT SYSTEM</p>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e5eee4] text-[#315c3d]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 7a3 3 0 11-6 0 3 3 0 016 0zM5.5 20a6.5 6.5 0 0113 0M18 8l1.5 1.5L22 7"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-sm font-semibold uppercase tracking-[.18em] text-[#527b5d]">
                        Welcome Back
                    </p>

                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Selamat Datang!
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-gray-500">
                        Masuk ke akunmu untuk melanjutkan pengelolaan
                        Sistem Penjurian Burung.
                    </p>
                </div>

                <!-- Session status -->
                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                            Alamat Email
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@email.com"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-4 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >
                        </div>

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                Password
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-medium text-[#527b5d] transition hover:text-[#244a32] hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M7 10V7a5 5 0 0110 0v3M6 10h12a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2v-7a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="form-input block w-full rounded-xl border border-gray-200 bg-white py-3.5 pl-12 pr-14 text-sm text-gray-800 outline-none placeholder:text-gray-400"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#315c3d]"
                            >
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.7">
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

                    <!-- Remember me -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#315c3d] focus:ring-[#527b5d]"
                        >

                        <label for="remember" class="ml-2 cursor-pointer text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="login-button flex w-full items-center justify-center gap-2 rounded-xl bg-[#315c3d] px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-green-900/10 hover:bg-[#244a32] focus:outline-none focus:ring-4 focus:ring-green-900/15"
                    >
                        Masuk ke Sistem

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/>
                        </svg>
                    </button>
                </form>

                <!-- Register link -->
                @if (Route::has('register'))
                    <div class="mt-7 text-center">
                        <p class="text-sm text-gray-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                               class="font-bold text-[#315c3d] transition hover:text-[#244a32] hover:underline">
                                Register
                            </a>
                        </p>
                    </div>
                @endif

                <div class="mt-10 border-t border-gray-200 pt-5 text-center">
                    <p class="text-xs leading-5 text-gray-400">
                        Sistem Penjurian Burung · Platform Pengelolaan Kompetisi
                    </p>
                </div>

            </div>
        </section>
    </main>

    <!-- Toggle password visibility -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
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
    </script>

</body>
</html>
