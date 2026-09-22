<x-catalog-layout>
    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-data="{ activeTab: 'profil', showDeleteModal: false }">

        {{-- Page Header & Breadcrumb --}}
        <div class="mb-8 pb-6 border-b border-slate-200">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-slate-700 transition">Beranda</a>
                <span>/</span>
                <span class="text-slate-700">Profil & Akun</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Profil & Pengaturan Akun</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Kelola informasi pribadi, status kamar sewa aktif, riwayat aktivitas, dan keamanan akun Anda.</p>
                </div>
                {{-- Tab Switcher Pills --}}
                <div class="inline-flex p-1 bg-white/80 backdrop-blur rounded-2xl border border-slate-200 shadow-2xs shrink-0">
                    <button @click="activeTab = 'profil'"
                            :class="activeTab === 'profil' ? 'bg-slate-900 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                            class="px-5 py-2 rounded-xl text-xs transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil & Hunian
                    </button>
                    <button @click="activeTab = 'keamanan'"
                            :class="activeTab === 'keamanan' ? 'bg-slate-900 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                            class="px-5 py-2 rounded-xl text-xs transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan
                    </button>
                </div>
            </div>
        </div>

        {{-- Quick Stats Strip (Desain Sederhana & Minimalis) --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 mb-8 shadow-2xs">
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 gap-4 sm:gap-0">
                <!-- Stat 1: Status Akun -->
                <div class="sm:px-6 first:sm:pl-2 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">STATUS AKUN</span>
                        <span class="text-sm font-bold text-slate-900 flex items-center gap-1.5 mt-0.5">
                            {{ auth()->user()->role === 'admin' ? 'Pengelola Kost' : 'Penyewa Terverifikasi' }}
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </span>
                        <p class="text-[11px] text-slate-400 font-medium">Sejak {{ auth()->user()->created_at ? auth()->user()->created_at->translatedFormat('d M Y') : '2025' }}</p>
                    </div>
                </div>

                <!-- Stat 2: Hunian Aktif -->
                <div class="pt-3 sm:pt-0 sm:px-6 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">HUNIAN AKTIF</span>
                        @if($activeBooking && $activeBooking->room)
                            <span class="text-sm font-bold text-slate-900 block truncate mt-0.5">Kamar {{ $activeBooking->room->room_number }}</span>
                            <p class="text-[11px] text-slate-500 font-medium truncate">Lantai {{ $activeBooking->room->floor_number }} • {{ $activeBooking->room->localized_room_type }}</p>
                        @else
                            <span class="text-sm font-bold text-slate-700 block mt-0.5">Belum Ada Kamar</span>
                            <a href="{{ route('catalog.index') }}" class="text-[11px] text-slate-500 hover:text-slate-800 font-semibold hover:underline">Pilih di katalog &rarr;</a>
                        @endif
                    </div>
                </div>

                <!-- Stat 3: Aktivitas Penyewa -->
                <div class="pt-3 sm:pt-0 sm:px-6 last:sm:pr-2 flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">AKTIVITAS PENYEWA</span>
                        <span class="text-sm font-bold text-slate-900 block mt-0.5">{{ $totalBookings ?? 0 }} Pemesanan Disewa</span>
                        <p class="text-[11px] text-slate-400 font-medium">{{ $totalComplaints ?? 0 }} Laporan kendala</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB CONTENT: Profil & Hunian --}}
        <div x-show="activeTab === 'profil'" x-transition.opacity.duration.200ms>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column (4 cols) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Kartu Profil -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs hover:shadow-md transition-all text-center group">
                        <!-- Avatar -->
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-3 border-emerald-100 group-hover:border-emerald-300 transition-colors shadow-inner flex items-center justify-center bg-gradient-to-br from-emerald-600 to-teal-700 text-white text-2xl font-extrabold tracking-tight">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-7 h-7 bg-emerald-500 text-white rounded-full flex items-center justify-center border-2 border-white shadow-xs" title="Akun Aktif">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>

                        <!-- Nama & Role -->
                        <h2 class="text-lg font-black text-slate-900 leading-tight">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h2>
                        <p class="text-xs font-semibold text-slate-400 mt-1 capitalize">{{ auth()->user()->role ?? 'Penyewa' }} • Kosify</p>

                        <!-- Verification Badge -->
                        <div class="flex items-center justify-center mt-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Identitas Terverifikasi
                            </span>
                        </div>

                        <!-- Detail Info Strip -->
                        <div class="mt-6 pt-5 border-t border-slate-100 text-left space-y-3.5 text-xs">
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">EMAIL</span>
                                    <span class="font-semibold text-slate-800 break-all">{{ auth()->user()->email ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">WHATSAPP</span>
                                    <span class="font-semibold text-slate-800">{{ auth()->user()->phone ?: 'Belum diisi' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">PEKERJAAN</span>
                                    <span class="font-semibold text-slate-800">{{ auth()->user()->occupation ?: 'Mahasiswa / Karyawan' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelengkapan Profil Card -->
                    @php
                        $completionFields = ['name', 'email', 'phone', 'occupation', 'kos_name'];
                        $filledFields = 0;
                        foreach($completionFields as $field) {
                            if (!empty(auth()->user()->$field)) $filledFields++;
                        }
                        $completionPercentage = round(($filledFields / count($completionFields)) * 100);
                    @endphp
                    <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-3xl p-5 shadow-2xs" x-data="{ width: 0 }" x-init="setTimeout(() => width = {{ $completionPercentage }}, 250)">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800">KELENGKAPAN PROFIL</span>
                            <span class="text-xs font-black text-emerald-700"><span x-text="width"></span>%</span>
                        </div>
                        <div class="w-full bg-emerald-200/60 rounded-full h-2 overflow-hidden mb-2.5">
                            <div class="bg-emerald-600 h-2 rounded-full transition-all duration-1000 ease-out" :style="`width: ${width}%`"></div>
                        </div>
                        <p class="text-[11px] text-emerald-800 font-medium leading-relaxed">
                            @if($completionPercentage >= 100)
                                Profil Anda sudah 100% lengkap! Kontrak dan koordinasi sewa kos berjalan lancar.
                            @else
                                Lengkapi kontak darurat & pekerjaan untuk mempermudah koordinasi pengelolaan sewa kos.
                            @endif
                        </p>
                    </div>

                    <!-- Bantuan & Kontak Pengelola (Sederhana & Bersih) -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-2xs">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.693.072-2.18-.546-1.898-.788-3.125-2.73-3.22-2.857-.095-.127-.768-1.021-.768-1.948 0-.927.487-1.383.66-1.573.173-.19.378-.238.505-.238.127 0 .254.002.365.007.119.006.278-.045.435.333.161.388.549 1.341.597 1.439.048.098.08.213.016.34-.064.127-.096.206-.19.317-.095.111-.2.247-.285.333-.096.095-.196.198-.085.389.111.19.492.813 1.055 1.314.724.644 1.334.843 1.524.938.19.095.301.079.412-.048.111-.127.476-.556.603-.746.127-.19.254-.159.428-.095.175.063 1.11.523 1.301.618.19.095.317.143.365.222.048.079.048.46-.096.865z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900">Bantuan Pengelola</h3>
                                <p class="text-[11px] text-slate-400">Pertanyaan seputar sewa & fasilitas kos</p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6285815721534')) }}?text={{ urlencode('Halo Pengelola Kosify, saya ' . auth()->user()->name . ' ingin menanyakan perihal kos...') }}" target="_blank" class="w-full inline-flex items-center justify-between px-3.5 py-2.5 bg-slate-50 hover:bg-slate-100 active:scale-98 text-slate-700 rounded-xl text-xs font-bold border border-slate-200 transition">
                            <span>Hubungi via WhatsApp</span>
                            <span class="text-slate-400">&rarr;</span>
                        </a>
                    </div>

                    <!-- Tindakan Akun Card -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-2xs space-y-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block px-1 mb-1">TINDAKAN AKUN</span>
                        <form method="POST" action="{{ route('logout') }}" data-turbo="false">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition active:scale-98">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar dari Akun
                                </span>
                                <span class="text-slate-400">&rarr;</span>
                            </button>
                        </form>
                        <button @click="showDeleteModal = true" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-red-600 hover:bg-red-50 transition active:scale-98">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Akun Permanen
                            </span>
                            <span class="text-red-400">&rarr;</span>
                        </button>
                    </div>

                </div>

                <!-- Right Column (8 cols) -->
                <div class="lg:col-span-8 space-y-8">

                    <!-- CARD 1: FORM INFORMASI PRIBADI -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">IDENTITAS DIRI</span>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight">Informasi Pribadi & Kontak</h2>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Perbarui informasi kontak dan identitas diri Anda untuk keperluan data sewa.</p>
                            </div>
                            <button type="submit" form="form-profile" class="px-5 py-2.5 bg-slate-900 hover:bg-black active:scale-95 text-white text-xs font-black uppercase tracking-wider rounded-xl transition shadow-xs flex items-center gap-2 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>

                        <form id="form-profile" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                                    @error('name') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                                    @error('email') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp Aktif</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx"
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                                    @error('phone') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pekerjaan / Instansi</label>
                                    <input type="text" name="occupation" value="{{ old('occupation', auth()->user()->occupation ?? '') }}" placeholder="Contoh: Mahasiswa / Software Engineer"
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                                    @error('occupation') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kontak Darurat / Kota Asal</label>
                                    <input type="text" name="kos_name" value="{{ old('kos_name', auth()->user()->kos_name ?? '') }}" placeholder="Misal: 08123456789 (Kakak / Orang Tua) - Surabaya"
                                           class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                                    <p class="text-[11px] text-slate-400 font-medium mt-1.5">Informasi kontak darurat digunakan pengelola hanya dalam keadaan mendesak di tempat kos.</p>
                                    @error('kos_name') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <div x-data="{ show: true }" x-show="show" x-transition.duration.400ms x-init="setTimeout(() => show = false, 4000)" class="mt-4 p-3 bg-emerald-50 border border-emerald-300 rounded-xl flex items-center gap-2 text-emerald-800 text-xs font-bold">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    Profil berhasil diperbarui dan disimpan.
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- CARD 2: STATUS HUNIAN & KAMAR SAYA -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">STATUS SEWA</span>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight">Kamar & Hunian Kos Anda</h2>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Rincian kamar kos yang sedang Anda tempati saat ini.</p>
                            </div>
                            @if($activeBooking && $activeBooking->room)
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-extrabold rounded-full border border-emerald-200 self-start sm:self-auto">
                                    SEWA AKTIF
                                </span>
                            @endif
                        </div>

                        @if($activeBooking && $activeBooking->room)
                            @php
                                $room = $activeBooking->room;
                                $photoUrl = $room->photo 
                                    ? (str_starts_with($room->photo, 'http') ? $room->photo : (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)))
                                    : asset('images/room_1.jpg');
                            @endphp
                            <div class="bg-slate-50/70 border border-slate-200 rounded-2xl p-5 flex flex-col md:flex-row gap-5 items-center">
                                <div class="w-full md:w-44 h-32 rounded-xl overflow-hidden shrink-0 relative">
                                    <img src="{{ $photoUrl }}" alt="Kamar {{ $room->room_number }}" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-slate-900/80 backdrop-blur text-white text-[10px] font-black rounded-lg">
                                        Lt. {{ $room->floor_number }}
                                    </span>
                                </div>
                                <div class="flex-1 w-full space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-lg font-black text-slate-900">Kamar {{ $room->room_number }}</h3>
                                        <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-black uppercase rounded-md tracking-wider">
                                            {{ $room->localized_room_type }}
                                        </span>
                                        <span class="text-xs text-slate-500 font-bold">
                                            • {{ $room->localized_zoning_badge }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $room->localized_description }}
                                    </p>
                                    <div class="pt-2 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200/60 text-xs">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase block">HARGA SEWA</span>
                                            <span class="font-extrabold text-slate-900">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-[10px] text-slate-400 font-normal"> / bulan</span></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('bookings.my') }}" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white text-[11px] font-bold rounded-lg transition active:scale-95">
                                                Detail Sewa &rarr;
                                            </a>
                                            <a href="{{ route('complaints.index') }}" class="px-3.5 py-1.5 bg-white border border-slate-300 hover:border-slate-800 text-slate-700 text-[11px] font-bold rounded-lg transition active:scale-95">
                                                Lapor Kendala
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Empty State Kamar yang Menarik & Rapi -->
                            <div class="bg-slate-50/70 border border-dashed border-slate-300 rounded-2xl p-8 text-center">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Kamar yang Disewa</h3>
                                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto mb-5 leading-relaxed">
                                    Anda belum memiliki reservasi kamar aktif. Jelajahi katalog kamar Kosify untuk melihat pilihan tipe kamar yang tersedia.
                                </p>
                                <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-black active:scale-95 text-white text-xs font-black uppercase tracking-wider rounded-xl transition shadow-xs">
                                    <span>Jelajahi Katalog Kamar</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- CARD 3: TATA TERTIB & PANDUAN PENGHUNI -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs">
                        <div class="mb-6 pb-4 border-b border-slate-100">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">KENYAMANAN BERSAMA</span>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">Panduan & Ketentuan Penghuni</h2>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Pedoman lingkungan untuk menjaga ketertiban, kebersihan, dan ketenangan sesama penghuni kos.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Rule 1 -->
                            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 hover:bg-white hover:border-slate-300 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-1">Jam Kunjungan</h3>
                                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                    Tamu non-penghuni diperkenankan berkunjung hingga pukul 22:00 WIB demi istirahat bersama.
                                </p>
                            </div>

                            <!-- Rule 2 -->
                            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 hover:bg-white hover:border-slate-300 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-1">Kebersihan Bersama</h3>
                                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                    Jaga kebersihan dapur, area jemur, dan parkir. Buang sampah pada tempat yang disediakan.
                                </p>
                            </div>

                            <!-- Rule 3 -->
                            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 hover:bg-white hover:border-slate-300 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-1">Layanan Kendala</h3>
                                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                    Ada kerusakan lampu, kran, AC, atau WiFi? Laporkan langsung lewat menu Lapor Kendala.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- TAB CONTENT: Keamanan --}}
        <div x-cloak x-show="activeTab === 'keamanan'" x-transition.opacity.duration.200ms>
            <div class="max-w-2xl space-y-6">

                <!-- Ubah Kata Sandi -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs">
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">KEAMANAN AKUN</span>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Kata Sandi</h2>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Gunakan kombinasi sandi yang kuat untuk melindungi akun Kosify Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                            @error('current_password', 'updatePassword') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                            @error('password', 'updatePassword') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full bg-slate-50/70 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
                            @error('password_confirmation', 'updatePassword') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2 flex items-center gap-4">
                            <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-black active:scale-95 text-white text-xs font-black uppercase tracking-wider rounded-xl transition shadow-xs">
                                Perbarui Sandi
                            </button>
                            @if (session('status') === 'password-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition.duration.400ms x-init="setTimeout(() => show = false, 4000)" class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    Kata sandi berhasil diperbarui.
                                </span>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Zona Berbahaya -->
                <div class="bg-red-50/40 rounded-3xl p-6 sm:p-8 border border-red-200">
                    <span class="text-[10px] font-black uppercase tracking-widest text-red-600 block mb-0.5">PERINGATAN KRUSIAL</span>
                    <h2 class="text-xl font-black text-red-700 tracking-tight">Zona Berbahaya</h2>
                    <p class="text-xs text-slate-600 font-medium mt-1 mb-6">
                        Menghapus akun Anda akan membatalkan seluruh reservasi, histori komplain, dan profil secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <button @click="showDeleteModal = true" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-black uppercase tracking-wider rounded-xl transition shadow-xs">
                        Hapus Akun Permanen
                    </button>
                </div>

            </div>
        </div>

        <!-- Modal Konfirmasi Hapus Akun -->
        <div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showDeleteModal" @click="showDeleteModal = false" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white p-6 sm:p-8 max-w-md w-full relative z-10 shadow-2xl rounded-3xl border border-slate-200">
                <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-1">Konfirmasi Hapus Akun</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-6">
                    Apakah Anda yakin ingin menghapus akun Anda? Masukkan kata sandi saat ini untuk melanjutkan konfirmasi penghapusan permanen.
                </p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')
                    <div>
                        <input type="password" name="password" placeholder="Masukkan kata sandi Anda" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold focus:bg-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition" required>
                        @error('password', 'userDeletion') <p class="text-[11px] text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="showDeleteModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-black uppercase tracking-wider rounded-xl transition shadow-xs">Hapus Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-catalog-layout>