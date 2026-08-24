<x-catalog-layout>
    <div class="min-h-screen pt-8 sm:pt-16 pb-16 sm:pb-24" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            
            {{-- Editorial Header --}}
            <div class="mb-10 sm:mb-14 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12">
                <div class="w-full md:w-1/2 md:pr-10">
                    <span class="inline-block px-3 py-1 bg-slate-200 text-slate-800 text-[10px] font-bold uppercase tracking-[0.25em] mb-3 sm:mb-4 rounded-md">
                        KATALOG RESMI
                    </span>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-4 sm:mb-6 leading-tight">
                        Temukan Kamar Impianmu.
                    </h1>
                    <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed mb-6 sm:mb-8 max-w-md font-medium">
                        Jelajahi berbagai pilihan kamar kos modern yang dirancang untuk kenyamanan, keamanan 24 jam, dan privasi optimal.
                    </p>
                </div>
                <div class="w-full md:w-1/2 relative hidden md:block">
                    <div class="aspect-[4/3] w-full overflow-hidden shadow-2xl relative rounded-2xl border border-slate-200">
                        <img src="{{ asset('images/deluxe_single_room.jpg') }}" alt="Interior Kos" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-slate-900/10 mix-blend-multiply"></div>
                    </div>
                </div>
            </div>

            {{-- Clean Pill Search & Custom Filter Bar (Gambar 2 Reference) --}}
            <div class="mb-14 max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-4">
                <!-- Search Capsule Input -->
                <div class="w-full flex-1 relative flex items-center bg-white rounded-full border-2 border-slate-700 hover:border-black focus-within:border-black focus-within:ring-2 focus-within:ring-slate-900/10 px-5 py-2.5 shadow-xs transition-all">
                    <input type="text" id="search-input" oninput="applyFilters()" value="{{ request('q') }}" placeholder="Search..." 
                        class="w-full bg-transparent border-0 focus:ring-0 text-slate-900 text-sm font-semibold placeholder-slate-400 outline-none pr-8">
                    <div class="absolute right-4 text-slate-600 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.35-4.35" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Hidden inputs for filter logic -->
                <input type="hidden" id="status-filter" value="all">
                <input type="hidden" id="price-filter" value="all">

                <!-- Filter Custom UI Dropdowns -->
                <div class="w-full md:w-auto flex items-center gap-3 shrink-0">
                    <!-- Status Custom Dropdown -->
                    <div class="relative flex-1 md:flex-initial" x-data="{ open: false, selected: 'all', label: 'Semua Status' }" @click.outside="open = false">
                        <button type="button" @click="open = !open" class="w-full md:w-auto flex items-center justify-between gap-3 bg-white border-2 border-slate-700 hover:border-black rounded-full px-5 py-2.5 text-xs font-black uppercase tracking-wider text-slate-800 transition-all shadow-xs focus:outline-none">
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full" :class="selected === 'available' ? 'bg-emerald-500' : (selected === 'occupied' ? 'bg-rose-500' : 'bg-slate-400')"></span>
                                <span x-text="label">Semua Status</span>
                            </span>
                            <svg class="w-4 h-4 text-slate-600 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Floating Custom Menu -->
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-40">
                            <button type="button" @click="selected = 'all'; label = 'Semua Status'; document.getElementById('status-filter').value = 'all'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 flex items-center justify-between transition-colors">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                    Semua Status
                                </span>
                                <span x-show="selected === 'all'" class="text-slate-900 font-black">✓</span>
                            </button>
                            <button type="button" @click="selected = 'available'; label = 'Tersedia'; document.getElementById('status-filter').value = 'available'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-emerald-700 hover:bg-emerald-50 flex items-center justify-between transition-colors">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Tersedia
                                </span>
                                <span x-show="selected === 'available'" class="text-emerald-700 font-black">✓</span>
                            </button>
                            <button type="button" @click="selected = 'occupied'; label = 'Terisi'; document.getElementById('status-filter').value = 'occupied'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 flex items-center justify-between transition-colors">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                    Terisi
                                </span>
                                <span x-show="selected === 'occupied'" class="text-slate-900 font-black">✓</span>
                            </button>
                        </div>
                    </div>

                    <!-- Price Custom Dropdown -->
                    <div class="relative flex-1 md:flex-initial" x-data="{ open: false, selected: 'all', label: 'Semua Harga' }" @click.outside="open = false">
                        <button type="button" @click="open = !open" class="w-full md:w-auto flex items-center justify-between gap-3 bg-white border-2 border-slate-700 hover:border-black rounded-full px-5 py-2.5 text-xs font-black uppercase tracking-wider text-slate-800 transition-all shadow-xs focus:outline-none">
                            <span x-text="label">Semua Harga</span>
                            <svg class="w-4 h-4 text-slate-600 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Floating Custom Menu -->
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                             class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-40">
                            <button type="button" @click="selected = 'all'; label = 'Semua Harga'; document.getElementById('price-filter').value = 'all'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 flex items-center justify-between transition-colors">
                                <span>Semua Harga</span>
                                <span x-show="selected === 'all'" class="text-slate-900 font-black">✓</span>
                            </button>
                            <button type="button" @click="selected = 'low'; label = '< Rp 1.500.000'; document.getElementById('price-filter').value = 'low'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 flex items-center justify-between transition-colors">
                                <span>&lt; Rp 1.500.000 <span class="text-[10px] text-slate-400 font-normal block">Ekonomis</span></span>
                                <span x-show="selected === 'low'" class="text-slate-900 font-black">✓</span>
                            </button>
                            <button type="button" @click="selected = 'high'; label = '≥ Rp 1.500.000'; document.getElementById('price-filter').value = 'high'; applyFilters(); open = false;"
                                class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 flex items-center justify-between transition-colors">
                                <span>&ge; Rp 1.500.000 <span class="text-[10px] text-slate-400 font-normal block">Deluxe / VIP</span></span>
                                <span x-show="selected === 'high'" class="text-slate-900 font-black">✓</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Katalog --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-16 max-w-5xl mx-auto" id="room-grid">
                @foreach($rooms as $room)
                    <div class="room-card group flex flex-col transition-all duration-300 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs hover:shadow-md"
                         data-name="{{ strtolower($room->room_number . ' ' . $room->room_type . ' ' . $room->description) }}"
                         data-status="{{ strtolower($room->status) }}"
                         data-price="{{ $room->price_per_month }}">
                        
                        {{-- Room Image --}}
                        <div class="relative aspect-video w-full overflow-hidden mb-5 rounded-2xl bg-slate-100 border border-slate-100">
                            @php
                                $photoUrl = $room->photo ? (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)) : asset('images/room_' . (($loop->index % 4) + 1) . '.jpg');
                            @endphp
                            <img src="{{ $photoUrl }}" alt="Kamar {{ $room->room_number }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        {{-- Room Details --}}
                        <div class="flex flex-col flex-1">
                            {{-- Header (Title + Badge) --}}
                            <div class="flex justify-between items-start mb-2 gap-4">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $room->room_type ?: 'STANDARD' }}</p>
                                    <h3 class="text-2xl font-black text-slate-900 group-hover:text-black transition-colors tracking-tight">
                                        Kamar {{ $room->room_number }}
                                    </h3>
                                </div>
                                <div class="shrink-0 pt-1">
                                    <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-black rounded-md border {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-slate-100 text-slate-600 border-slate-300' }}">
                                        {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'TERSEDIA' : 'TERISI' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Micro Info (Text-First) --}}
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-4 pb-3 border-b border-slate-100 font-bold uppercase tracking-wider">
                                <span>LOKASI: PUSAT KOTA</span>
                                <span>•</span>
                                <span class="text-slate-900">RATING: 4.9 / 5.0</span>
                            </div>
                            
                            {{-- Description --}}
                            <p class="text-xs text-slate-600 leading-relaxed mb-5 line-clamp-2 font-medium">
                                {{ $room->description ?: 'Kos eksklusif dengan fasilitas lengkap kasur empuk, meja kerja, lemari, WiFi cepat, dan akses gerbang mandiri 24 jam.' }}
                            </p>

                            {{-- Amenities Tags (Text Pills) --}}
                            <div class="flex flex-wrap gap-1.5 mb-6">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">WIFI FIBER</span>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">AC / FAN</span>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">KM DALAM</span>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">KASUR</span>
                            </div>

                            {{-- Price & CTA Button --}}
                            <div class="mt-auto flex justify-between items-center pt-3 border-t border-slate-100">
                                <div>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">TARIF SEWA</p>
                                    <p class="text-lg font-black text-slate-900">
                                        Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-xs text-slate-400 font-semibold"> / BLN</span>
                                    </p>
                                </div>
                                <a href="{{ route('rooms.detail', $room->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black text-xs font-black uppercase tracking-wider transition-all shadow-xs">
                                    LIHAT DETAIL &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            <div id="empty-state" class="hidden text-center py-20 bg-white rounded-3xl border border-slate-200 max-w-lg mx-auto">
                <span class="text-xs font-black uppercase tracking-widest text-slate-400 block mb-2">[ DATA KOSONG ]</span>
                <h3 class="text-xl font-black text-slate-900 mb-2">Kamar Tidak Ditemukan</h3>
                <p class="text-slate-500 text-xs font-medium mb-6">Coba sesuaikan filter status, harga, atau kata kunci pencarian Anda.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-2.5 bg-slate-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-slate-800 transition-colors">
                    RESET FILTER
                </a>
            </div>
            
        </div>
    </div>

    {{-- Latest Articles Section (Text-First) --}}
    <div class="max-w-5xl mx-auto px-4 mt-24 mb-20">
        <div class="flex justify-between items-end mb-8 border-b border-slate-200 pb-4">
            <div>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1 font-bold">ARTIKEL & TIPS</p>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">Panduan & Berita Kosify</h2>
            </div>
            <a href="#" class="px-5 py-2 bg-slate-900 hover:bg-black text-white text-[11px] font-bold tracking-wider uppercase rounded-lg transition-all">
                SEMUA ARTIKEL &rarr;
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <div class="flex flex-col group cursor-pointer bg-white p-5 rounded-2xl border border-slate-200">
                <div class="aspect-[4/3] w-full bg-slate-100 overflow-hidden mb-4 rounded-xl">
                    <img src="{{ asset('images/vip_double_room.jpg') }}" alt="News 1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex flex-col flex-1">
                    <p class="text-sm font-bold text-slate-900 leading-snug mb-4 group-hover:text-slate-600 transition-colors">
                        Menikmati Keindahan Alam di Sekitar Kosify, Destinasi Akhir Pekan.
                    </p>
                    <div class="mt-auto">
                        <span class="text-[11px] text-slate-900 font-bold uppercase tracking-wider hover:underline">
                            BACA ARTIKEL &rarr;
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="flex flex-col group cursor-pointer bg-white p-5 rounded-2xl border border-slate-200">
                <div class="aspect-[4/3] w-full bg-slate-100 overflow-hidden mb-4 rounded-xl">
                    <img src="{{ asset('images/deluxe_single_room.jpg') }}" alt="News 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex flex-col flex-1">
                    <p class="text-sm font-bold text-slate-900 leading-snug mb-4 group-hover:text-slate-600 transition-colors">
                        Tips Menata Kamar Kos Minimalis agar Terasa Lebih Luas dan Nyaman.
                    </p>
                    <div class="mt-auto">
                        <span class="text-[11px] text-slate-900 font-bold uppercase tracking-wider hover:underline">
                            BACA ARTIKEL &rarr;
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="flex flex-col group cursor-pointer bg-white p-5 rounded-2xl border border-slate-200">
                <div class="aspect-[4/3] w-full bg-slate-100 overflow-hidden mb-4 rounded-xl">
                    <img src="{{ asset('images/curtain-bg.jpg') }}" alt="News 3" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex flex-col flex-1">
                    <p class="text-sm font-bold text-slate-900 leading-snug mb-4 group-hover:text-slate-600 transition-colors">
                        Panduan Lengkap Memilih Fasilitas Kos Sesuai dengan Kebutuhan.
                    </p>
                    <div class="mt-auto">
                        <span class="text-[11px] text-slate-900 font-bold uppercase tracking-wider hover:underline">
                            BACA ARTIKEL &rarr;
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function applyFilters() {
            const searchVal = (document.getElementById('search-input')?.value || '').toLowerCase().trim();
            const statusVal = document.getElementById('status-filter')?.value || 'all';
            const priceVal = document.getElementById('price-filter')?.value || 'all';
            
            const cards = document.querySelectorAll('.room-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const name = (card.getAttribute('data-name') || '').toLowerCase();
                const status = (card.getAttribute('data-status') || '').toLowerCase();
                const price = parseFloat(card.getAttribute('data-price')) || 0;
                
                let matchSearch = !searchVal || name.includes(searchVal);
                let matchStatus = statusVal === 'all' || status === statusVal || (statusVal === 'available' && status === 'tersedia');
                let matchPrice = priceVal === 'all' || 
                    (priceVal === 'low' && price < 1500000) || 
                    (priceVal === 'high' && price >= 1500000);
                
                if (matchSearch && matchStatus && matchPrice) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            const emptyState = document.getElementById('empty-state');
            if (visibleCount === 0) {
                emptyState?.classList.remove('hidden');
            } else {
                emptyState?.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', applyFilters);
        document.addEventListener('turbo:load', applyFilters);
    </script>
</x-catalog-layout>
