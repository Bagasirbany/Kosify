<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Akun - Kosify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        [x-cloak] { display: none !important; }
    </style>
    <meta name="turbo-prefetch" content="true">
    <script type="module">
        import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="text-xl font-extrabold text-emerald-700 cursor-default tracking-tight">Kosify</span>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" data-turbo="false" class="text-gray-600 hover:text-emerald-700 transition">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="text-gray-600 hover:text-emerald-700 transition">Catalog</a>
                    <a href="{{ route('bookings.my') }}" class="text-gray-600 hover:text-emerald-700 transition">My Bookings</a>
                    <a href="{{ route('profile.edit') }}" class="text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-0.5">Profile</a>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </div>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50" style="display:none;">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Admin Dashboard</a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" data-turbo="false">@csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-700">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg transition">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-6 pt-10 pb-16" x-data="{ activeTab: 'profil', showDeleteModal: false }">

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola identitas profil, detail operasional kost, dan keamanan akun Anda.</p>
        </div>

        <!-- Tabs -->
        <div class="flex items-center gap-8 border-b border-gray-200 mb-8">
            <button @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'border-emerald-500 text-emerald-700 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-3 text-sm border-b-2 transition-colors">
                Profil Saya
            </button>
            <button @click="activeTab = 'keamanan'"
                    :class="activeTab === 'keamanan' ? 'border-emerald-500 text-emerald-700 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-3 text-sm border-b-2 transition-colors">
                Keamanan
            </button>
        </div>

        <!-- Profil Tab -->
        <div x-show="activeTab === 'profil'" x-transition.opacity.duration.200ms>
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Left Column: Profile Card -->
                <div class="w-full lg:w-80 flex-shrink-0 space-y-5">

                    <!-- Profile Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-default group">
                        <!-- Avatar -->
                        <div class="relative w-28 h-28 mx-auto mb-4">
                            <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-gray-100 group-hover:border-emerald-200 transition-colors duration-300">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=059669&color=fff&size=200&font-size=0.35" alt="Avatar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <button type="button" class="absolute bottom-0 right-1 w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-emerald-600 active:scale-90 transition-all duration-200 border-2 border-white hover:rotate-12">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                        </div>

                        <!-- Name & Role -->
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-emerald-700 transition-colors duration-300">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5 capitalize">{{ auth()->user()->role ?? 'Penyewa' }}</p>

                        <!-- Badges -->
                        <div class="flex items-center justify-center gap-2 mt-3">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                Terverifikasi
                            </span>
                        </div>

                        <!-- Contact Info -->
                        <div class="mt-6 text-left space-y-4 border-t border-gray-100 pt-5">
                            <div class="hover:translate-x-1 transition-transform duration-300">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Email</p>
                                <p class="text-sm font-medium text-gray-800 mt-0.5">{{ auth()->user()->email ?? '-' }}</p>
                            </div>
                            <div class="hover:translate-x-1 transition-transform duration-300">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">No. Telepon</p>
                                <p class="text-sm font-medium text-gray-800 mt-0.5">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Completion Card -->
                    @php
                        $completionFields = ['name', 'email', 'phone', 'occupation'];
                        $filledFields = 0;
                        foreach($completionFields as $field) {
                            if (!empty(auth()->user()->$field)) $filledFields++;
                        }
                        $completionPercentage = round(($filledFields / count($completionFields)) * 100);
                    @endphp
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-default" x-data="{ width: 0 }" x-init="setTimeout(() => width = {{ $completionPercentage }}, 300)">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-sm font-bold text-emerald-800">Lengkapi Profil</h3>
                        </div>
                        <p class="text-xs text-emerald-700 leading-relaxed mb-3">Profil yang lengkap meningkatkan kepercayaan penyewa sebesar 40%.</p>
                        <!-- Progress Bar -->
                        <div class="w-full bg-emerald-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-emerald-600 h-2 rounded-full transition-all duration-1000 ease-out" :style="`width: ${width}%`"></div>
                        </div>
                        <p class="text-xs font-semibold text-emerald-700 mt-2"><span x-text="width"></span>% Selesai</p>
                    </div>

                    <!-- Tindakan Akun Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-3 hover:shadow-lg transition-all duration-300">
                        <h3 class="text-sm font-bold text-gray-700 mb-2">Tindakan Akun</h3>
                        <form method="POST" action="{{ route('logout') }}" data-turbo="false">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 px-3 py-2 rounded-lg transition-colors active:scale-95 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar dari Akun
                            </button>
                        </form>
                        <button @click="showDeleteModal = true" class="w-full flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg transition-colors active:scale-95 group">
                            <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Akun
                        </button>
                    </div>
                </div>

                <!-- Right Column: Forms -->
                <div class="flex-1 space-y-6">

                    <!-- Informasi Pribadi -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900">Informasi Pribadi</h2>
                            <button type="submit" form="form-profile" class="bg-emerald-700 hover:bg-emerald-800 active:scale-95 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>

                        <form id="form-profile" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-5">
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Nomor WhatsApp</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Pekerjaan</label>
                                    <input type="text" name="occupation" value="{{ old('occupation', auth()->user()->occupation ?? '') }}" placeholder="Masukkan pekerjaan Anda"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                                    @error('occupation') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 mt-4 font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Berhasil disimpan.</p>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Keamanan Tab (placeholder for tab switching) -->
        <div x-cloak x-show="activeTab === 'keamanan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
            <div class="max-w-2xl">
                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6 hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Ubah Kata Sandi</h2>
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                            @error('current_password', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Kata Sandi Baru</label>
                            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                            @error('password', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-600 mb-1.5 group-hover:text-emerald-700 transition-colors duration-200">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:-translate-y-0.5 focus:shadow-md transition-all duration-300 hover:border-emerald-300">
                            @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 active:scale-95 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition-all duration-200 shadow-sm mt-2 hover:shadow-md">
                                Perbarui Sandi
                            </button>
                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 mt-2 font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Kata sandi diperbarui.</p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white border border-red-200 rounded-xl p-6 hover:shadow-lg hover:border-red-300 transition-all duration-300">
                    <h2 class="text-lg font-bold text-red-700 mb-2">Zona Berbahaya</h2>
                    <p class="text-sm text-gray-500 mb-4">Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.</p>
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('logout') }}" data-turbo="false">@csrf
                            <button type="submit" class="text-sm font-semibold text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 active:scale-95 transition-all duration-200 hover:border-gray-400">Keluar Sesi</button>
                        </form>
                        <button @click="showDeleteModal = true" class="text-sm font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-95 px-4 py-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">Hapus Akun</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div x-show="showDeleteModal" @click="showDeleteModal = false" x-transition.opacity class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm"></div>
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white p-6 max-w-sm w-full relative z-10 shadow-2xl rounded-xl border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-2">Hapus Akun Permanen?</h2>
                <p class="text-sm text-gray-600 mb-6">Semua data akan dihapus selamanya. Masukkan kata sandi untuk konfirmasi.</p>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="mb-5">
                        <input type="password" name="password" placeholder="Kata Sandi Anda" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition" required>
                        @error('password', 'userDeletion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showDeleteModal = false" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 rounded-lg transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition">Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    @include('partials.footer')
</body>
</html>