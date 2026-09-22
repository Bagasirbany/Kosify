<x-catalog-layout>
    <div class="min-h-screen pt-8 sm:pt-12 pb-16 sm:pb-24" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            
            {{-- Editorial Header Container (Sesuai Permintaan User) --}}
            <div class="mb-6 sm:mb-8 w-full bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 lg:p-10 transition-all">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8">
                    <div class="w-full md:w-1/2 md:pr-4">
                        <span class="inline-block px-3 py-1 bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-[0.25em] mb-3 rounded-md border border-slate-200">
                            {{ __('messages.catalog_hero_badge') }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl md:text-4xl font-black text-slate-900 mb-3 leading-tight tracking-tight">
                            {{ __('messages.catalog_hero_title') }}
                        </h1>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-0 max-w-md font-medium">
                            {{ __('messages.catalog_hero_desc') }}
                        </p>
                    </div>
                    <div class="w-full md:w-1/2 relative hidden md:block">
                        <div class="aspect-[16/10] w-full overflow-hidden shadow-sm relative rounded-2xl border border-slate-200">
                            <img src="{{ asset('images/rooms/room_201.jpg') }}" alt="Interior Kos" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-slate-900/10 mix-blend-multiply"></div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Filter Bar (Sesuai Persis Desain Referensi) --}}
            <div class="mb-6 w-full bg-white rounded-3xl border border-slate-200 shadow-xs px-5 sm:px-6 py-3.5 sm:py-4 transition-all"
                 x-data="{
                     statusSelected: 'all',
                     statusLabel: '{{ __('messages.status_all') }}',
                     priceSelected: 'all',
                     priceLabel: '{{ __('messages.price_all') }}',
                     statusOpen: false,
                     priceOpen: false
                 }"
                 @reset-catalog-filters.window="
                     statusSelected = 'all';
                     statusLabel = '{{ __('messages.status_all') }}';
                     priceSelected = 'all';
                     priceLabel = '{{ __('messages.price_all') }}';
                 ">
                <!-- Hidden inputs for filter logic (Search is in Header Navbar) -->
                <input type="hidden" id="search-input" value="{{ request('q') }}">
                <input type="hidden" id="status-filter" value="all">
                <input type="hidden" id="price-filter" value="all">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3.5 sm:gap-4">
                    
                    {{-- Left: Informasi Jumlah Unit (Bersih & Elegan) --}}
                    <div>
                        <p class="text-xs text-slate-500 font-medium">
                            @if(app()->getLocale() === 'en')
                                Showing <span id="visible-count" class="font-bold text-slate-900">{{ $rooms->count() }}</span> rooms
                            @else
                                Menampilkan <span id="visible-count" class="font-bold text-slate-900">{{ $rooms->count() }}</span> unit kamar
                            @endif
                        </p>
                    </div>

                    {{-- Right: Filter Controls (Status & Harga) --}}
                    <div class="flex items-center gap-2.5 sm:gap-3">
                        
                        <!-- Status Dropdown -->
                        <div class="relative" @click.outside="statusOpen = false">
                            <button type="button" @click="statusOpen = !statusOpen; priceOpen = false;" 
                                    class="flex items-center justify-between gap-2.5 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2 text-xs transition-colors shadow-2xs focus:outline-none select-none cursor-pointer">
                                <span class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">{{ __('messages.status_filter') }}</span>
                                    <span x-text="statusLabel" class="font-bold text-slate-900">{{ __('messages.status_all') }}</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-600 transition-transform duration-200" :class="statusOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="statusOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-1.5 z-50">
                                
                                <button type="button" @click="statusSelected = 'all'; statusLabel = '{{ __('messages.status_all') }}'; document.getElementById('status-filter').value = 'all'; applyFilters(); statusOpen = false;"
                                    :class="statusSelected === 'all' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span>{{ __('messages.status_all') }}</span>
                                    <span x-show="statusSelected === 'all'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>
                                
                                <button type="button" @click="statusSelected = 'available'; statusLabel = '{{ __('messages.status_available') }}'; document.getElementById('status-filter').value = 'available'; applyFilters(); statusOpen = false;"
                                    :class="statusSelected === 'available' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>{{ __('messages.status_available') }}</span>
                                    </span>
                                    <span x-show="statusSelected === 'available'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>

                                <button type="button" @click="statusSelected = 'occupied'; statusLabel = '{{ __('messages.status_occupied') }}'; document.getElementById('status-filter').value = 'occupied'; applyFilters(); statusOpen = false;"
                                    :class="statusSelected === 'occupied' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span>{{ __('messages.status_occupied') }}</span>
                                    <span x-show="statusSelected === 'occupied'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Price Dropdown -->
                        <div class="relative" @click.outside="priceOpen = false">
                            <button type="button" @click="priceOpen = !priceOpen; statusOpen = false;" 
                                    class="flex items-center justify-between gap-2.5 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-2xl px-4 py-2 text-xs transition-colors shadow-2xs focus:outline-none select-none cursor-pointer">
                                <span class="flex items-center gap-1.5">
                                    <span class="text-slate-400 font-medium">{{ __('messages.price_filter') }}</span>
                                    <span x-text="priceLabel" class="font-bold text-slate-900">{{ __('messages.price_all') }}</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-600 transition-transform duration-200" :class="priceOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="priceOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 p-1.5 z-50">
                                
                                <button type="button" @click="priceSelected = 'all'; priceLabel = '{{ __('messages.price_all') }}'; document.getElementById('price-filter').value = 'all'; applyFilters(); priceOpen = false;"
                                    :class="priceSelected === 'all' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span>{{ __('messages.price_all') }}</span>
                                    <span x-show="priceSelected === 'all'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>
                                
                                <button type="button" @click="priceSelected = 'low'; priceLabel = '{{ __('messages.price_low_label') }}'; document.getElementById('price-filter').value = 'low'; applyFilters(); priceOpen = false;"
                                    :class="priceSelected === 'low' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span>&lt; Rp 1.500.000 <span class="opacity-70 text-[10px] font-normal block">{{ __('messages.price_budget') }}</span></span>
                                    <span x-show="priceSelected === 'low'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>

                                <button type="button" @click="priceSelected = 'high'; priceLabel = '{{ __('messages.price_high_label') }}'; document.getElementById('price-filter').value = 'high'; applyFilters(); priceOpen = false;"
                                    :class="priceSelected === 'high' ? 'bg-slate-900 text-white font-bold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                    class="w-full text-left px-3 py-2 text-xs rounded-xl flex items-center justify-between transition-colors cursor-pointer">
                                    <span>&ge; Rp 1.500.000 <span class="opacity-70 text-[10px] font-normal block">{{ __('messages.price_deluxe') }}</span></span>
                                    <span x-show="priceSelected === 'high'" class="text-[9px] uppercase font-bold tracking-wider opacity-80">{{ __('messages.selected') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <button id="reset-filter-btn" type="button" onclick="resetAllFilters()" 
                                class="hidden text-xs font-bold text-slate-400 hover:text-slate-800 underline transition-colors cursor-pointer px-1">
                            {{ __('messages.reset_filter') }}
                        </button>
                    </div>

                </div>
            </div>

            {{-- Grid Katalog (Jarak Renggang 1cm / gap-y-6, Sejajar dengan Filter) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 w-full" id="room-grid">
                @foreach($rooms as $room)
                    @php
                        $rType = strtoupper($room->room_type ?? '');
                    @endphp
                    <div class="room-card group flex flex-col transition-all duration-300 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs hover:shadow-md"
                         data-name="{{ strtolower($room->room_number . ' ' . $room->room_type . ' ' . $room->description) }}"
                         data-status="{{ strtolower($room->status) }}"
                         data-price="{{ $room->price_per_month }}">
                        
                        {{-- Room Image --}}
                        <div class="relative aspect-video w-full overflow-hidden mb-5 rounded-2xl bg-slate-100 border border-slate-100">
                            @php
                                $photoUrl = $room->photo ? (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)) : asset('images/room_' . (($loop->index % 4) + 1) . '.jpg');
                            @endphp
                            <img src="{{ $photoUrl }}" alt="{{ __('messages.room') }} {{ $room->room_number }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        {{-- Room Details --}}
                        <div class="flex flex-col flex-1 justify-between">
                            <div>
                                {{-- Header: Type, Zoning & Availability --}}
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                            {{ $room->room_type ?: 'Standard' }}
                                        </span>
                                        <span class="text-slate-300">&bull;</span>
                                        <span class="text-xs font-medium text-slate-600">
                                            {{ $room->localized_zoning_badge }}
                                        </span>
                                    </div>

                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }} text-xs font-semibold whitespace-nowrap shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? __('messages.status_available') : __('messages.status_occupied') }}
                                    </span>
                                </div>

                                {{-- Room Title --}}
                                <h3 class="text-2xl font-bold text-slate-900 group-hover:text-slate-700 transition-colors tracking-tight mb-2">
                                    <a href="{{ route('rooms.detail', $room->id) }}">
                                        {{ __('messages.room') }} {{ $room->room_number }}
                                    </a>
                                </h3>

                                {{-- Key Facilities & Rating (Clean Inline) --}}
                                @php
                                    $roomRevCount = $room->reviews ? $room->reviews->count() : 0;
                                    $roomAvg = $roomRevCount > 0 ? round($room->reviews->avg('rating'), 1) : null;
                                @endphp
                                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-4 flex-wrap">
                                    <span>WiFi</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span>AC</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span>KM Dalam</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span>Kasur</span>
                                    @if($roomRevCount > 0)
                                        <span class="text-slate-300">&bull;</span>
                                        <span class="text-slate-700 font-semibold flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ number_format($roomAvg, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Price & CTA Button --}}
                            <div class="pt-4 border-t border-slate-100 flex justify-between items-center mt-2">
                                <div>
                                    <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider leading-none mb-1">{{ __('messages.rental_rate') }}</p>
                                    <p class="text-lg font-bold text-slate-900 tracking-tight">
                                        Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">{{ __('messages.per_month_short') }}</span>
                                    </p>
                                </div>
                                <a href="{{ route('rooms.detail', $room->id) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-xs font-semibold transition-all shadow-2xs flex items-center gap-1.5">
                                    <span>{{ __('messages.view_detail') }}</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            <div id="empty-state" class="hidden text-center py-20 bg-white rounded-3xl border border-slate-200 max-w-lg mx-auto">
                <span class="text-xs font-black uppercase tracking-widest text-slate-400 block mb-2">[ {{ app()->getLocale() === 'en' ? 'NO RESULTS' : 'DATA KOSONG' }} ]</span>
                <h3 class="text-xl font-black text-slate-900 mb-2">{{ __('messages.empty_rooms_title') }}</h3>
                <p class="text-slate-500 text-xs font-medium mb-6">{{ __('messages.empty_rooms_desc') }}</p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-2.5 bg-slate-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-slate-800 transition-colors">
                    {{ __('messages.reset_filter') }}
                </a>
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
            
            const countElem = document.getElementById('visible-count');
            if (countElem) countElem.innerText = visibleCount;

            const isFiltered = (searchVal !== '') || (statusVal !== 'all') || (priceVal !== 'all');
            const activeBadge = document.getElementById('active-filter-badge');
            const resetBtn = document.getElementById('reset-filter-btn');
            if (activeBadge) activeBadge.classList.toggle('hidden', !isFiltered);
            if (resetBtn) resetBtn.classList.toggle('hidden', !isFiltered);

            const emptyState = document.getElementById('empty-state');
            if (visibleCount === 0) {
                emptyState?.classList.remove('hidden');
            } else {
                emptyState?.classList.add('hidden');
            }
        }

        function resetAllFilters() {
            const searchInput = document.getElementById('search-input');
            if (searchInput) searchInput.value = '';
            const headerSearch = document.getElementById('header-search-input');
            if (headerSearch) headerSearch.value = '';
            const statusInput = document.getElementById('status-filter');
            if (statusInput) statusInput.value = 'all';
            const priceInput = document.getElementById('price-filter');
            if (priceInput) priceInput.value = 'all';
            
            window.dispatchEvent(new CustomEvent('reset-catalog-filters'));
            applyFilters();
        }

        document.addEventListener('DOMContentLoaded', applyFilters);
        document.addEventListener('turbo:load', applyFilters);
    </script>
</x-catalog-layout>
