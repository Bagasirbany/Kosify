<x-catalog-layout>
    <div class="min-h-screen pt-6 sm:pt-8 pb-20 sm:pb-24" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm font-medium text-slate-500 mb-6 sm:mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">{{ __('messages.nav_home') }}</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </li>
                    <li>
                        <a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">{{ __('messages.nav_catalog') }}</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </li>
                    <li class="text-slate-900 font-bold" aria-current="page">{{ __('messages.room') }} {{ $room->room_number }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-start">
                
                {{-- Left Column: Image & Details --}}
                <div class="md:col-span-2 space-y-6 sm:space-y-8">
                    
                    @php
                        $mainPhoto = $room->photo 
                            ? (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo))
                            : asset('images/deluxe_single_room.jpg');

                        $angleLabels = [
                            0 => __('messages.angle_main'),
                            1 => __('messages.angle_desk'),
                            2 => __('messages.angle_wardrobe'),
                            3 => __('messages.angle_bath'),
                            4 => __('messages.angle_window'),
                        ];

                        $slides = [];
                        $slides[] = [
                            'url' => $mainPhoto,
                            'label' => __('messages.angle_main'),
                            'badge' => __('messages.angle_badge_main'),
                            'desc' => __('messages.angle_desc_main'),
                        ];

                        if (!empty($room->gallery_photos) && is_array($room->gallery_photos)) {
                            foreach ($room->gallery_photos as $idx => $gPhoto) {
                                $url = (str_starts_with($gPhoto, 'images/') || str_starts_with($gPhoto, 'http'))
                                    ? asset($gPhoto)
                                    : asset('storage/' . $gPhoto);
                                if ($url !== $mainPhoto && count($slides) < 5) {
                                    $currIndex = count($slides);
                                    $slides[] = [
                                        'url' => $url,
                                        'label' => $angleLabels[$currIndex] ?? ($currIndex + 1),
                                        'badge' => ($currIndex + 1),
                                        'desc' => __('messages.angle_desc_desk'),
                                    ];
                                }
                            }
                        }

                        // Fallback angle photos to ensure at least 4 angles
                        $defaultAngles = [
                            ['url' => asset('images/room_1.jpg'), 'label' => __('messages.angle_desk'), 'badge' => __('messages.angle_badge_desk'), 'desc' => __('messages.angle_desc_desk')],
                            ['url' => asset('images/room_2.jpg'), 'label' => __('messages.angle_wardrobe'), 'badge' => __('messages.angle_badge_wardrobe'), 'desc' => __('messages.angle_desc_wardrobe')],
                            ['url' => asset('images/room_3.jpg'), 'label' => __('messages.angle_bath'), 'badge' => __('messages.angle_badge_bath'), 'desc' => __('messages.angle_desc_bath')],
                            ['url' => asset('images/room_4.jpg'), 'label' => __('messages.angle_window'), 'badge' => __('messages.angle_badge_window'), 'desc' => __('messages.angle_desc_window')],
                        ];

                        foreach ($defaultAngles as $angle) {
                            if (count($slides) >= 4) break;
                            $exists = false;
                            foreach ($slides as $s) {
                                if ($s['url'] === $angle['url']) {
                                    $exists = true;
                                    break;
                                }
                            }
                            if (!$exists) {
                                $slides[] = $angle;
                            }
                        }
                    @endphp

                    {{-- Interactive Room Slider (Sisi-Sisi Kamar) --}}
                    <div x-data="{ 
                        activeIndex: 0, 
                        total: {{ count($slides) }},
                        next() { this.activeIndex = (this.activeIndex + 1) % this.total; },
                        prev() { this.activeIndex = (this.activeIndex - 1 + this.total) % this.total; },
                        goTo(index) { this.activeIndex = index; }
                    }" 
                    @keydown.arrow-right.window="next()"
                    @keydown.arrow-left.window="prev()"
                    class="space-y-3">
                        
                        {{-- Main Viewport Slider --}}
                        <div class="bg-slate-900 rounded-3xl overflow-hidden shadow-xs border border-slate-200 aspect-[16/10] max-h-[380px] md:max-h-[400px] lg:max-h-[440px] relative group select-none">
                            
                            {{-- Slides --}}
                            @foreach($slides as $index => $slide)
                                <div x-show="activeIndex === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-300 transform"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-200 transform"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute inset-0 w-full h-full">
                                    <img src="{{ $slide['url'] }}" 
                                         alt="Kamar {{ $room->room_number }} - {{ $slide['label'] }}" 
                                         class="w-full h-full object-cover">
                                    
                                    {{-- Vignette gradient overlay --}}
                                    <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/70 via-slate-950/25 to-transparent pointer-events-none"></div>
                                </div>
                            @endforeach



                            {{-- Top Right: Counter Badge --}}
                            <div class="absolute top-4 right-4 z-20">
                                <div class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold border border-white/10 shadow-xs flex items-center gap-1.5">
                                    <span x-text="activeIndex + 1">1</span>
                                    <span class="text-white/50">/</span>
                                    <span>{{ count($slides) }} {{ __('messages.photos_count') }}</span>
                                </div>
                            </div>

                            {{-- Prev & Next Navigation Buttons (Subtle, Clean) --}}
                            <button type="button" 
                                    @click.prevent="prev()" 
                                    aria-label="Previous Photo"
                                    class="absolute left-3.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/90 hover:bg-white text-slate-800 flex items-center justify-center shadow-md backdrop-blur-md transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer border border-slate-200/80">
                                <svg class="w-4 h-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>

                            <button type="button" 
                                    @click.prevent="next()" 
                                    aria-label="Next Photo"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/90 hover:bg-white text-slate-800 flex items-center justify-center shadow-md backdrop-blur-md transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer border border-slate-200/80">
                                <svg class="w-4 h-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>

                            {{-- Bottom Right: Link to Full Gallery --}}
                            <a href="{{ route('rooms.gallery', $room->id) }}" 
                               class="absolute bottom-3.5 right-3.5 z-20 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 hover:bg-white text-slate-900 text-[11px] font-bold shadow-xs backdrop-blur-md transition-all duration-200 hover:scale-105 active:scale-95 border border-slate-200/80">
                                <svg class="w-3.5 h-3.5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span>{{ __('messages.view_all_photos') }}</span>
                            </a>

                            {{-- Bottom Center Dots --}}
                            <div class="absolute bottom-3.5 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-950/40 backdrop-blur-md border border-white/10">
                                @foreach($slides as $index => $slide)
                                    <button type="button" 
                                            @click="goTo({{ $index }})" 
                                            :class="activeIndex === {{ $index }} ? 'w-4 bg-white' : 'w-1.5 bg-white/40 hover:bg-white/70'"
                                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                                            aria-label="Photo {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Side/Angle Thumbnails Strip (Gambar Sisi-Sisi Kamar) --}}
                        <div>
                            <div class="flex items-center justify-between mb-2 px-1">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('messages.select_angle') }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium hidden sm:inline">
                                    {{ __('messages.click_angle_hint') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                                @foreach($slides as $index => $slide)
                                    <button type="button" 
                                            @click="goTo({{ $index }})" 
                                            :class="activeIndex === {{ $index }} ? 'ring-2 ring-slate-900 ring-offset-2 border-transparent' : 'border-slate-200 hover:border-slate-400 opacity-75 hover:opacity-100'" 
                                            class="group text-left rounded-xl overflow-hidden bg-white border shadow-2xs transition-all duration-200 relative aspect-[16/10] flex flex-col focus:outline-none cursor-pointer">
                                        <img src="{{ $slide['url'] }}" 
                                             alt="{{ $slide['label'] }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent p-1.5 pt-3">
                                            <p class="text-[10px] font-bold text-white truncate">{{ $slide['label'] }}</p>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Title & Info --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 sm:gap-6 mb-6">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ __('messages.room') }} {{ $room->room_number }}</h1>
                                    @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                            {{ __('messages.status_available') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                            {{ __('messages.status_occupied') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-slate-500 font-medium text-xs sm:text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $settings['kos_address'] ?? 'Jl. Kaliurang KM 5.2 No. 18, Caturtunggal, Sleman, D.I. Yogyakarta 55281' }}</span>
                                </p>

                                {{-- Zoning Policy Tag --}}
                                <div class="mt-3 inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-xl {{ $room->floor_number === 1 ? 'bg-blue-50 text-blue-900 border border-blue-200/80' : 'bg-purple-50 text-purple-900 border border-purple-200/80' }}">
                                    <span class="w-2 h-2 rounded-full {{ $room->floor_number === 1 ? 'bg-blue-600' : 'bg-purple-600' }} shrink-0"></span>
                                    <span class="text-xs font-bold tracking-tight">{{ $room->localized_zoning_badge }}</span>
                                    <span class="opacity-40">•</span>
                                    <span class="text-[11px] font-medium opacity-90">{{ $room->zoning_description }}</span>
                                </div>
                            </div>
                            <div class="text-left sm:text-right shrink-0">
                                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ __('messages.monthly_rate') }}</p>
                                <p class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight whitespace-nowrap">
                                    Rp {{ number_format($room->price_per_month, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-slate-100 my-8">

                        {{-- Spesifikasi Dimensi & Ukuran Kamar --}}
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-slate-900 mb-4">{{ __('messages.dimensions_specs') }}</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">{{ __('messages.room_width_label') }}</span>
                                    <span class="text-lg font-black text-slate-900 block">3.0 Meter</span>
                                    <span class="text-[10px] text-slate-500 font-medium">Sisi horizontal</span>
                                </div>
                                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">{{ __('messages.room_length_label') }}</span>
                                    <span class="text-lg font-black text-slate-900 block">4.0 Meter</span>
                                    <span class="text-[10px] text-slate-500 font-medium">Sisi vertikal</span>
                                </div>
                                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">{{ __('messages.total_area_label') }}</span>
                                    <span class="text-lg font-black text-slate-900 block">12.0 m²</span>
                                    <span class="text-[10px] text-slate-500 font-medium">Standar lega</span>
                                </div>
                                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">{{ __('messages.ceiling_height_label') }}</span>
                                    <span class="text-lg font-black text-slate-900 block">3.2 Meter</span>
                                    <span class="text-[10px] text-slate-500 font-medium">Ventilasi adem</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kepemilikan Kamar Kos (Dikelola Langsung oleh Pemilik) --}}
                        <div class="mb-8 p-5 bg-slate-50 rounded-2xl border border-slate-200/80">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1.5">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold tracking-wider uppercase bg-slate-200/70 text-slate-700">
                                        {{ __('messages.managed_by_owner') }}
                                    </div>
                                    <h4 class="text-base font-bold text-slate-900">
                                        {{ $settings['owner_name'] ?? 'Bagas Irbany' }}
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed max-w-xl">
                                        {{ app()->getLocale() === 'en' ? 'This room is rented directly by the owner without middleman or additional commission fees. Feel free to reach out for availability, room viewing, or questions.' : 'Kamar ini disewakan langsung oleh pemilik tanpa perantara atau biaya komisi tambahan. Anda dapat berkonsultasi langsung perihal ketersediaan kamar, survei tempat, atau informasi fasilitas kos.' }}
                                    </p>
                                </div>
                                <div class="shrink-0 flex flex-col gap-2">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $settings['owner_phone'] ?? '6285815721534')) }}?text={{ urlencode((app()->getLocale() === 'en' ? 'Hello, I would like to inquire about Room ' : 'Halo Mas Bagas Irbany, saya ingin bertanya tentang Kamar ') . $room->room_number) }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-slate-800 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.97.589 1.771.913 2.796.913 3.179 0 5.767-2.587 5.767-5.766.001-3.182-2.585-5.768-5.767-5.768zm3.364 8.163c-.141.396-.816.746-1.127.794-.3.048-.682.072-2.18-.549-1.898-.788-3.125-2.738-3.22-2.864-.095-.127-.768-1.021-.768-1.947 0-.925.485-1.381.658-1.57.172-.19.376-.238.502-.238.126 0 .252.002.361.008.115.006.269-.044.42.321.157.38.535 1.304.582 1.4.047.095.078.207.016.333-.063.127-.095.206-.188.317-.095.111-.199.248-.285.333-.095.095-.194.198-.083.388.111.19.493.813 1.057 1.316.726.647 1.339.848 1.53.943.19.095.301.079.412-.048.111-.127.476-.555.603-.745.127-.19.254-.159.428-.095.175.063 1.111.524 1.302.619.19.095.317.143.365.222.048.079.048.46-.093.856z"/>
                                        </svg>
                                        <span>{{ __('messages.contact_owner') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-4">{{ __('messages.desc_and_facilities') }}</h3>
                            <div class="text-slate-600 leading-relaxed font-medium">
                                <p>{{ $room->localized_description }}</p>
                            </div>
                            
                            {{-- Fasilitas --}}
                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ __('messages.amenity_bath') }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ __('messages.amenity_wifi') }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ __('messages.amenity_ac') }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ __('messages.amenity_bed') }} &amp; {{ __('messages.amenity_wardrobe') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Persyaratan Awal Sewa Kos --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                            <div>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200/70 mb-1.5">
                                    {{ __('messages.terms_badge') }}
                                </div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ __('messages.terms_title') }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ __('messages.terms_subtitle') }}</p>
                            </div>
                            <div class="hidden sm:flex w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200/80 items-center justify-center text-slate-700 shadow-2xs">
                                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Syarat 1: Identitas --}}
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-900 shrink-0 font-black text-xs shadow-2xs">
                                    1
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 mb-1">{{ __('messages.term_id_title') }}</h4>
                                    <p class="text-[11.5px] text-slate-600 leading-relaxed">{{ __('messages.term_id_desc') }}</p>
                                </div>
                            </div>

                            {{-- Syarat 2: Kontak Darurat --}}
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-900 shrink-0 font-black text-xs shadow-2xs">
                                    2
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 mb-1">{{ __('messages.term_contact_title') }}</h4>
                                    <p class="text-[11.5px] text-slate-600 leading-relaxed">{{ __('messages.term_contact_desc') }}</p>
                                </div>
                            </div>

                            {{-- Syarat 3: Pembayaran & Deposit --}}
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-900 shrink-0 font-black text-xs shadow-2xs">
                                    3
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 mb-1">{{ __('messages.term_payment_title') }}</h4>
                                    <p class="text-[11.5px] text-slate-600 leading-relaxed">{{ __('messages.term_payment_desc') }}</p>
                                </div>
                            </div>

                            {{-- Syarat 4: Ketentuan Pasutri --}}
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-900 shrink-0 font-black text-xs shadow-2xs">
                                    4
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 mb-1">{{ __('messages.term_marriage_title') }}</h4>
                                    <p class="text-[11.5px] text-slate-600 leading-relaxed">{{ __('messages.term_marriage_desc') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Info Komitmen Ketertiban Bersama --}}
                        <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <p class="text-xs text-emerald-950 leading-relaxed">
                                <span class="font-bold text-emerald-900">{{ __('messages.term_rules_note_title') }}:</span> {{ __('messages.term_rules_note_desc') }}
                            </p>
                        </div>
                    </div>

                    {{-- Section: Ulasan & Rating Penghuni --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ __('messages.reviews_and_ratings') }}</h3>

                                <p class="text-xs text-slate-500">{{ __('messages.reviews_subtitle') }}</p>
                            </div>
                            <div class="flex items-center gap-3 bg-amber-50/80 px-4 py-2 rounded-2xl border border-amber-200">
                                <svg class="w-6 h-6 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <div>
                                    @if(isset($totalReviews) && $totalReviews > 0)
                                        <span class="font-extrabold text-slate-900 text-base">{{ number_format($averageRating, 1) }}</span>
                                        <span class="text-xs text-slate-500">/ 5.0 ({{ $totalReviews }} {{ $totalReviews == 1 ? __('messages.review') : __('messages.reviews_count') }})</span>
                                    @else
                                        <span class="font-bold text-slate-700 text-xs">{{ __('messages.no_reviews') }}</span>
                                        <span class="text-[10px] text-slate-400 block">(0 {{ __('messages.reviews_count') }})</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(isset($errors) && $errors->any())
                            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold space-y-1">
                                @foreach($errors->all() as $error)
                                    <p>• {{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        {{-- Form Tulis Ulasan (Hanya Penyewa Sah yang Belum Memberikan Ulasan) --}}
                        @if($canReview)
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">{{ __('messages.write_review_title') }}</h4>
                                <form action="{{ route('rooms.review', $room->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div class="flex items-center gap-3">
                                        <label class="text-xs font-semibold text-slate-600">{{ __('messages.give_rating') }}</label>
                                        <select name="rating" required class="text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 bg-white focus:ring-1 focus:ring-slate-900">
                                            <option value="5">5 Bintang - ★★★★★</option>
                                            <option value="4">4 Bintang - ★★★★</option>
                                            <option value="3">3 Bintang - ★★★</option>
                                            <option value="2">2 Bintang - ★★</option>
                                            <option value="1">1 Bintang - ★</option>
                                        </select>
                                    </div>
                                    <textarea name="comment" rows="2" required placeholder="{{ __('messages.review_placeholder') }}" class="w-full text-xs p-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-1 focus:ring-slate-900"></textarea>
                                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-lg shadow-sm transition-colors cursor-pointer">
                                        {{ __('messages.submit_review_btn') }}
                                    </button>
                                </form>
                            </div>
                        @elseif(auth()->check() && ($hasReviewed ?? false))
                            <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200/80 flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-700 font-black text-sm">
                                    ✓
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-emerald-900">{{ __('messages.review_submitted') }}</p>
                                    <p class="text-[11px] text-emerald-700 font-medium">{{ __('messages.review_submitted_desc') }}</p>
                                </div>
                            </div>
                        @elseif(auth()->check())
                            @if(auth()->user()->role === 'admin')
                                <div class="bg-indigo-50/70 p-4 rounded-2xl border border-indigo-200/80 flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center shrink-0 text-indigo-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-indigo-900">{{ __('messages.admin_monitor_mode') }}</p>
                                        <p class="text-[11px] text-indigo-700 font-medium">{{ __('messages.admin_monitor_desc') }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-slate-200 flex items-center justify-center shrink-0 text-slate-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ __('messages.tenant_only_review') }}</p>
                                        <p class="text-[11px] text-slate-500">{{ __('messages.tenant_only_desc') }}</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">{{ __('messages.want_to_review') }}</p>
                                    <p class="text-[11px] text-slate-500">{{ __('messages.want_to_review_desc') }}</p>
                                </div>
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm shrink-0">
                                    {{ __('messages.nav_login') }}
                                </a>
                            </div>
                        @endif

                        {{-- List Reviews (Publik: Siapapun dapat melihat) --}}
                        <div class="space-y-4 pt-2">
                            @if(isset($room->reviews) && $room->reviews->count() > 0)
                                @foreach($room->reviews as $rev)
                                    <div class="border-b border-slate-100 last:border-0 pb-4">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center">
                                                    {{ strtoupper(substr($rev->user->name ?? 'P', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="text-xs font-bold text-slate-900 block">{{ $rev->user->name ?? 'User' }}</span>
                                                    <span class="text-[10px] text-slate-400">{{ $rev->created_at ? $rev->created_at->diffForHumans() : 'Just now' }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center gap-0.5 text-amber-500">
                                                    @for($s = 1; $s <= 5; $s++)
                                                        <svg class="w-3.5 h-3.5 {{ $s <= $rev->rating ? 'text-amber-500 fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @auth
                                                    @if(auth()->id() === $rev->user_id)
                                                        <form action="{{ route('reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-[10px] text-rose-500 hover:text-rose-700 font-bold underline">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <p class="text-xs text-slate-600 leading-relaxed pl-10">{{ $rev->comment }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    <p>{{ __('messages.no_reviews_yet_desc') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column: Booking Box --}}
                <div class="md:col-span-1">
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-xs sticky top-24">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ __('messages.book_room') }}</h3>
                            @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ __('messages.status_available') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    {{ __('messages.status_occupied') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-slate-500 font-medium text-sm mb-6">{{ __('messages.pick_date_cost') }}</p>

                        @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                            {{-- We keep the reservation logic in the backend later, for now we keep the form --}}
                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5" x-data="bookingForm()">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">{{ __('messages.start_date') }}</label>
                                    <input type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required x-model="startDate" @change="calculate"
                                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block p-3 font-medium transition-colors">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">{{ __('messages.duration_months') }}</label>
                                    <select name="duration_months" required x-model="duration" @change="calculate"
                                            class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block p-3 font-medium cursor-pointer transition-colors">
                                        @for($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ __('messages.months_unit') }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div x-show="total > 0" class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3 mt-6">
                                    <div class="flex justify-between text-sm font-medium text-slate-600">
                                        <span>Rp {{ number_format($room->price_per_month, 0, ',', '.') }} x <span x-text="duration"></span> {{ __('messages.months_unit') }}</span>
                                        <span x-text="formatCurrency(subtotal)"></span>
                                    </div>
                                    <div class="flex justify-between text-sm font-medium text-slate-600">
                                        <span>{{ __('messages.service_fee') }}</span>
                                        <span x-text="formatCurrency(serviceFee)"></span>
                                    </div>
                                    <hr class="border-slate-200 my-2">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-900">{{ __('messages.total_payment') }}</span>
                                        <span class="text-xl font-black text-slate-900" x-text="formatCurrency(total)"></span>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3.5 px-4 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm cursor-pointer">
                                        {{ __('messages.proceed_to_payment') }}
                                    </button>
                                </div>
                                <div class="pt-1 text-center">
                                    <p class="text-[11px] text-slate-500 flex items-center justify-center gap-1.5 font-medium">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ app()->getLocale() === 'en' ? 'Simple requirements: Valid ID & quick approval' : 'Syarat mudah: Cukup KTP / KTM & verifikasi instan' }}</span>
                                    </p>
                                </div>
                            </form>
                        @else
                            <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl text-center">
                                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mx-auto mb-3 shadow-sm text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-1">{{ __('messages.room_unavailable') }}</h4>
                                <p class="text-sm text-slate-500 font-medium">{{ __('messages.room_unavailable_desc') }}</p>
                                <a href="{{ route('catalog.index') }}" class="mt-5 block w-full py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors">
                                    {{ __('messages.find_other_room') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if(in_array(strtolower($room->status), ['available', 'tersedia']))
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingForm', () => ({
                startDate: '{{ date('Y-m-d') }}',
                duration: 1,
                pricePerMonth: {{ $room->price_per_month }},
                subtotal: 0,
                serviceFee: 50000,
                total: 0,
                
                init() {
                    this.calculate();
                },
                
                calculate() {
                    if(this.startDate && this.duration > 0) {
                        this.subtotal = this.pricePerMonth * this.duration;
                        this.total = this.subtotal + this.serviceFee;
                    } else {
                        this.total = 0;
                    }
                },
                
                formatCurrency(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                }
            }))
        })
    </script>
    @endif
</x-catalog-layout>