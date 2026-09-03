<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Akun Google</title>
    <link rel="icon" type="image/svg+xml" href="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif; }
        body { background-color: #131314; color: #e3e3e3; }
        .account-item:hover { background-color: #28292a; }
        .border-google { border-color: #3c4043; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 select-none">

    <div class="flex-1 flex items-center justify-center">
        <!-- Main Google Dialog Box (Dark Theme matching reference) -->
        <div class="w-full max-w-[460px] bg-[#1f1f1f] rounded-[28px] border border-[#3c4043] p-8 shadow-2xl">
            
            <!-- Google Header -->
            <div class="flex items-center gap-2.5 mb-6">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span class="text-sm font-medium text-[#c4c7c5]">Login dengan Google</span>
            </div>

            <!-- App Icon & Title -->
            <div class="flex items-center gap-3.5 mb-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/favicon-circle.png') }}" class="w-7 h-7 object-contain" alt="Kosify">
                </div>
            </div>

            <h1 class="text-2xl font-normal text-white mb-1">Pilih akun</h1>
            <p class="text-sm text-[#8ab4f8] hover:underline cursor-pointer mb-6">
                Lanjutkan ke <span class="font-medium">Kosify</span>
            </p>

            <!-- Accounts List -->
            <div class="divide-y divide-[#3c4043] border-y border-[#3c4043] -mx-8 px-2 mb-6">
                
                <!-- Account 1: Bagas Irbany (Primary) -->
                <form method="POST" action="{{ route('login.google.select') }}">
                    @csrf
                    <input type="hidden" name="email" value="irbanybagas@gmail.com">
                    <input type="hidden" name="name" value="Bagas Irbany">
                    <button type="submit" class="w-full text-left flex items-center gap-4 px-6 py-3.5 account-item rounded-2xl transition-colors group">
                        <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-medium flex items-center justify-center text-sm flex-shrink-0 border border-emerald-500/50">
                            B
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">Bagas Irbany</p>
                            <p class="text-xs text-[#9aa0a6] truncate">irbanybagas@gmail.com</p>
                        </div>
                        <svg class="w-4 h-4 text-[#9aa0a6] opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                <!-- Account 2: Alternative Google Account -->
                <form method="POST" action="{{ route('login.google.select') }}">
                    @csrf
                    <input type="hidden" name="email" value="penyewa.kosify@gmail.com">
                    <input type="hidden" name="name" value="Penyewa Baru">
                    <button type="submit" class="w-full text-left flex items-center gap-4 px-6 py-3.5 account-item rounded-2xl transition-colors group">
                        <div class="w-9 h-9 rounded-full bg-blue-700 text-white font-medium flex items-center justify-center text-sm flex-shrink-0 border border-blue-500/50">
                            P
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">Penyewa Baru</p>
                            <p class="text-xs text-[#9aa0a6] truncate">penyewa.kosify@gmail.com</p>
                        </div>
                        <svg class="w-4 h-4 text-[#9aa0a6] opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                <!-- Option: Use another account -->
                <div id="custom-account-btn" onclick="toggleCustomAccount()" class="flex items-center gap-4 px-6 py-3.5 account-item rounded-2xl transition-colors cursor-pointer">
                    <div class="w-9 h-9 rounded-full bg-[#28292a] text-[#c4c7c5] flex items-center justify-center text-sm flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-white">Gunakan akun lain</p>
                </div>

                <!-- Custom Account Form (Hidden by default) -->
                <div id="custom-account-form" style="display: none;" class="px-6 py-4 bg-[#28292a] rounded-2xl my-2">
                    <form method="POST" action="{{ route('login.google.select') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs text-[#9aa0a6] mb-1 font-medium">Masukkan Email Google Anda:</label>
                            <input type="email" name="email" required placeholder="email@gmail.com" class="w-full bg-[#1f1f1f] border border-[#3c4043] rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-[#8ab4f8]">
                        </div>
                        <div>
                            <input type="text" name="name" required placeholder="Nama Anda" class="w-full bg-[#1f1f1f] border border-[#3c4043] rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-[#8ab4f8]">
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <button type="submit" class="px-4 py-1.5 bg-[#8ab4f8] text-[#131314] font-medium text-xs rounded-lg hover:bg-blue-300 transition-colors">Lanjutkan</button>
                            <button type="button" onclick="toggleCustomAccount()" class="px-3 py-1.5 text-xs text-[#9aa0a6] hover:text-white">Batal</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Disclaimer Text -->
            <p class="text-xs text-[#9aa0a6] leading-relaxed mb-4">
                Sebelum menggunakan aplikasi ini, Anda dapat meninjau 
                <a href="#" class="text-[#8ab4f8] hover:underline">Kebijakan Privasi</a> dan 
                <a href="#" class="text-[#8ab4f8] hover:underline">Persyaratan Layanan</a> Kosify.
            </p>

            <div class="pt-2 border-t border-[#3c4043] flex items-center justify-between text-xs text-[#9aa0a6]">
                <a href="{{ route('login') }}" class="hover:text-white flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Kosify</span>
                </a>
                <span class="text-[11px] text-[#5f6368]">Google Identity Services</span>
            </div>

        </div>
    </div>

    <!-- Google Footer -->
    <div class="w-full max-w-[460px] mx-auto flex items-center justify-between text-xs text-[#9aa0a6] pt-4 px-2">
        <div class="flex items-center gap-1 cursor-pointer hover:text-white">
            <span>Indonesia</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div class="flex items-center gap-6">
            <a href="#" class="hover:text-white">Bantuan</a>
            <a href="#" class="hover:text-white">Privasi</a>
            <a href="#" class="hover:text-white">Persyaratan</a>
        </div>
    </div>

    <script>
        function toggleCustomAccount() {
            const form = document.getElementById('custom-account-form');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</body>
</html>
