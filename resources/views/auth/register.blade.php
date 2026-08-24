<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Baru - Kosify</title>

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
            <p class="text-slate-500 font-medium text-xs uppercase tracking-wider">Pendaftaran Akun Baru Penyewa / Pengguna</p>
        </div>

        <!-- Form Card (Text-First) -->
        <div class="w-full max-w-[420px] bg-white rounded-3xl border border-slate-200 shadow-xs p-8">
            
            <div class="mb-6 pb-4 border-b border-slate-100">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">REGISTRASI</span>
                <h1 class="text-xl font-black text-slate-900">Buat Akun Baru</h1>
                <p class="text-slate-500 text-xs mt-0.5 font-medium">Lengkapi formulir di bawah untuk memulai reservasi kamar kos.</p>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4" data-turbo="false">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Contoh: Budi Santoso"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label for="phone" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor WhatsApp</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                           placeholder="081234567890"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                </div>

                <!-- Email Aktif -->
                <div>
                    <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Aktif</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@email.com"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                </div>

                <!-- Kata Sandi -->
                <div>
                    <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Minimal 8 karakter"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 pr-16 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                        <button type="button" onclick="togglePass('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase tracking-wider text-slate-400 hover:text-slate-900">
                            LIHAT
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="Ulangi kata sandi"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 pr-16 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 transition-colors">
                        <button type="button" onclick="togglePass('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase tracking-wider text-slate-400 hover:text-slate-900">
                            LIHAT
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3 rounded-xl bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider transition-all shadow-md mt-4">
                    DAFTAR SEKARANG &rarr;
                </button>
            </form>

            <div class="text-center mt-6 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-600 font-medium">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:underline uppercase tracking-wider">Masuk</a>
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
