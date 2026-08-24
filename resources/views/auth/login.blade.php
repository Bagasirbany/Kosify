<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk ke Akun - Kosify</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 relative flex flex-col justify-between">
    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-6 py-12">
        
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-14 w-auto object-contain">
            </a>
            <p class="text-slate-500 font-medium text-xs uppercase tracking-wider">Portal Masuk Akun Pengguna & Admin</p>
        </div>

        <!-- Form Card (Text-First) -->
        <div class="w-full max-w-[420px] bg-white rounded-3xl border border-slate-200 shadow-xs p-8">
            
            <div class="mb-6 pb-4 border-b border-slate-100">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">AUTENTIKASI</span>
                <h1 class="text-xl font-black text-slate-900">Masuk ke Akun</h1>
                <p class="text-slate-500 text-xs mt-0.5 font-medium">Masukkan kredensial terdaftar Anda untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 px-4 py-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                    <ul class="space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4" data-turbo="false">
                @csrf

                <!-- Email Aktif -->
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Terdaftar</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="nama@email.com"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                </div>

                <!-- Kata Sandi -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 pr-16 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                        <button type="button" onclick="togglePass('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase tracking-wider text-slate-400 hover:text-slate-900">
                            LIHAT
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-1">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                    <label for="remember_me" class="ml-2 block text-xs font-bold text-slate-600 uppercase tracking-wider">
                        Ingat Saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3 rounded-xl bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider transition-all shadow-md mt-4">
                    MASUK KE AKUN &rarr;
                </button>
            </form>

            <div class="text-center mt-6 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-600 font-medium">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-slate-900 hover:underline uppercase tracking-wider">Daftar Sekarang</a>
                </p>
            </div>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full px-8 py-6 text-center text-xs font-bold uppercase tracking-wider text-slate-400 border-t border-slate-200">
        &copy; 2026 KOSIFY INDONESIA. ALL RIGHTS RESERVED.
    </footer>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.innerText = 'SEMBUNYIKAN';
                } else {
                    input.type = 'password';
                    btn.innerText = 'LIHAT';
                }
            }
        }
    </script>
</body>
</html>
