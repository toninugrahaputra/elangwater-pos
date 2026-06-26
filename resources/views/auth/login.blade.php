<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Elang Water POS & ERP</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />

    <!-- CSS & JS Assets (Tailwind v4 via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome & Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert2 for Interactive UI Popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FCFAF6; /* cream */
            background-image: radial-gradient(at top left, rgba(255,255,255,0.6) 0%, transparent 25%);
        }

        .login-container {
            @apply min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8;
        }

        .login-card {
            @app w-full max-w-md space-y-6;
            @apply bg-white border border-cream-dark rounded-3xl p-10 shadow-xl;
        }

        .login-header {
            @app text-center mb-8;
        }

        .login-header h1 {
            @app text-3xl font-extrabold tracking-tight text-zinc-900 mb-2;
        }

        .login-header p {
            @app text-zinc-500 text-base mt-0;
        }

        .login-form {
            @app space-y-5;
        }

        .form-group {
            @app space-y-3;
        }

        .form-label {
            @app text-sm font-semibold text-zinc-500;
        }

        .form-input {
            @app w-full px-5 py-4 rounded-2xl border border-cream-dark bg-cream text-zinc-900
                   focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white
                   transition-all text-base;
        }

        .form-input:focus {
            @app border-primary;
        }

        .submit-button {
            @app w-full flex items-center justify-center gap-3 px-5 py-4 bg-primary
                   hover:bg-primary-dark text-zinc-900 font-bold rounded-2xl
                   text-base transition-all hover:shadow-lg transform hover:scale-[1.02];
        }

        .submit-button:hover {
            @app bg-primary-dark;
        }

        .footer-text {
            @app text-sm text-zinc-400 text-center mt-8;
        }

        .footer-link {
            @app text-primary hover:text-primary-dark font-medium underline;
        }

        .error-message {
            @app bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700 rounded-xl;
        }

        @media (prefers-color-scheme: dark) {
            body {
                @app bg-zinc-900;
                background-image: radial-gradient(at top left, rgba(255,255,255,0.1) 0%, transparent 25%);
            }

            .login-card {
                @app bg-zinc-800/50 backdrop-blur-sm border border-zinc-700;
            }

            .form-input {
                @app bg-zinc-800 border-zinc-700 text-zinc-100 placeholder-zinc-400;
            }

            .form-input:focus {
                @app bg-zinc-700;
            }

            .footer-text {
                @app text-zinc-500;
            }
        }
    </style>
</head>
<body class="h-screen flex flex-col">
    <div class="login-container flex-1">
        <div class="login-card bg-white border border-cream-dark rounded-3xl p-10 shadow-xl">
            <div class="login-header">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-primary flex items-center justify-center rounded-2xl">
                        <i data-lucide="droplet" class="w-8 h-8 text-white"></i>
                    </div>
                </div>
                <h1>Masuk ke Akun Anda</h1>
                <p>Selamat datang kembali ke Elang Water POS & ERP</p>
            </div>

            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="login-form space-y-5" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-input block w-full" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input id="password" type="password" class="form-input block w-full" name="password" required autocomplete="current-password">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" name="remember">
                        <label for="remember" class="ml-2 text-sm text-zinc-500">Ingat Saya</label>
                    </div>

                    <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="submit-button w-full">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    Masuk
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} Elang Water POS & ERP. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>
</body>
</html>