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
            background-color: #FCFAF6;
            background-image: radial-gradient(at top left, rgba(255,255,255,0.6) 0%, transparent 25%);
        }
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #18181b;
                background-image: radial-gradient(at top left, rgba(255,255,255,0.05) 0%, transparent 25%);
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-6 bg-white border border-cream-dark rounded-3xl p-10 shadow-xl dark:bg-zinc-800/50 dark:backdrop-blur-sm dark:border-zinc-700">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-primary flex items-center justify-center rounded-2xl shadow-md animate-pulse">
                    <i data-lucide="droplet" class="w-8 h-8 text-white"></i>
                </div>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-zinc-900 mb-2 dark:text-zinc-100">Masuk ke Akun Anda</h1>
            <p class="text-zinc-500 text-base mt-0 dark:text-zinc-400">Selamat datang kembali ke Elang Water POS & ERP</p>
        </div>

        <!-- Errors -->
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700 rounded-xl dark:bg-red-950/20 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700 rounded-xl dark:bg-red-950/20 dark:text-red-300">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form class="space-y-5" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Email</label>
                <input id="email" type="email" class="w-full px-5 py-4 rounded-2xl border border-cream-dark bg-cream text-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white focus:border-primary transition-all text-base dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100 dark:placeholder-zinc-400 dark:focus:bg-zinc-700" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Kata Sandi</label>
                <input id="password" type="password" class="w-full px-5 py-4 rounded-2xl border border-cream-dark bg-cream text-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white focus:border-primary transition-all text-base dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100 dark:placeholder-zinc-400 dark:focus:bg-zinc-700" name="password" required autocomplete="current-password">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-zinc-300 dark:border-zinc-700 rounded bg-white dark:bg-zinc-800" name="remember">
                    <label for="remember" class="ml-2 text-sm text-zinc-500 dark:text-zinc-400">Ingat Saya</label>
                </div>

                <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium transition-colors">Lupa Kata Sandi?</a>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-3 px-5 py-4 bg-primary hover:bg-primary-dark text-zinc-900 font-bold rounded-2xl text-base transition-all hover:shadow-lg transform hover:scale-[1.02]">
                <i data-lucide="log-in" class="w-5 h-5"></i>
                Masuk
            </button>
        </form>

        <div class="text-sm text-zinc-400 text-center mt-8 dark:text-zinc-500">
            &copy; {{ date('Y') }} Elang Water POS & ERP. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>