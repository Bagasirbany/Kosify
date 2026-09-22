<x-public-layout>
    <!-- ============ HERO SECTION ============ -->
    <section id="beranda" class="pt-4 sm:pt-6 pb-8 sm:pb-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto h-[60vh] sm:h-[70vh] min-h-[440px] sm:min-h-[500px] max-h-[700px] relative rounded-2xl sm:rounded-3xl overflow-hidden group bg-black">
            <!-- Background Image (High Priority LCP) -->
            <img src="{{ isset($settings['hero_image']) && $settings['hero_image'] != '' ? (str_starts_with($settings['hero_image'], 'images/') ? asset($settings['hero_image']) : asset('storage/' . $settings['hero_image'])) : asset('images/deluxe_single_room.jpg') }}" alt="Modern Kos Room" fetchpriority="high" decoding="async" class="w-full h-full object-cover">
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex flex-col items-start justify-end text-left px-5 sm:px-8 md:px-16 pb-8 sm:pb-16 md:pb-24">
                <h1 class="text-white font-black text-4xl sm:text-6xl lg:text-7xl tracking-tight mb-3 sm:mb-4 drop-shadow-lg">
                    {{ $settings['hero_title'] ?? 'KOSIFY' }}
                </h1>
                <p class="text-white/90 font-medium text-sm sm:text-lg md:text-xl max-w-2xl mb-6 sm:mb-10 drop-shadow-md">
                    {{ $settings['hero_subtitle'] ?? 'Temukan kos impianmu dengan fasilitas lengkap, desain estetis, dan proses booking yang bebas ribet dalam satu platform.' }}
                </p>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full sm:w-auto">
                    <!-- Primary Button (Text-First) -->
                    <a href="{{ route('catalog.index') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-slate-900 font-black text-sm uppercase tracking-wider rounded-full hover:bg-slate-100 hover:shadow-xl transition-all duration-300 w-full sm:w-auto text-center">
                        <span>{{ $settings['hero_button_text'] ?? 'Cari Kamarmu' }}</span>
                        <span class="font-bold text-slate-900 group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHY CHOOSE US ============ -->
    <section id="keunggulan" class="py-20 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left: Stats -->
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6">
                    {{ __('messages.advantages_title') }}
                </h2>
                <p class="text-slate-600 mb-12 leading-relaxed font-medium text-sm">
                    {{ __('messages.advantages_desc') }}
                </p>
                
                <div class="grid grid-cols-3 border-t border-slate-200 pt-8 text-center gap-4">
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">12k+</span>
                        <p class="text-xs uppercase tracking-wider text-slate-500 font-bold mt-1">{{ __('messages.stat_satisfied') }}</p>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">{{ __('messages.stat_exp_val') }}</span>
                        <p class="text-xs uppercase tracking-wider text-slate-500 font-bold mt-1">{{ __('messages.stat_experience') }}</p>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">50+</span>
                        <p class="text-xs uppercase tracking-wider text-slate-500 font-bold mt-1">{{ __('messages.stat_locations') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right: Feature Cards (Typography-Driven) -->
            <div class="flex flex-col gap-4">
                <!-- Card 1 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100/80 transition-colors">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        01
                    </span>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">{{ __('messages.curation_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.curation_desc') }}</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100/80 transition-colors">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        02
                    </span>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">{{ __('messages.easy_booking_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.easy_booking_desc') }}</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100/80 transition-colors">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        03
                    </span>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">{{ __('messages.support_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.support_desc') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============ TOP ROOMS (CATALOG) ============ -->
    <section id="katalog" class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">{{ __('messages.top_rooms_title') }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                @forelse($popularRooms as $room)
                <!-- Modern White Card (Photo on Top, Clean White Content on Bottom) -->
                <a href="{{ route('rooms.detail', $room->id) }}" 
                   class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
                    
                    @php
                        $roomPhoto = $room->photo;
                        if (!$roomPhoto) {
                            $fallbackIndex = ($loop->index % 4) + 1;
                            $roomPhoto = "images/room_{$fallbackIndex}.jpg";
                        }
                        $floorNumber = substr($room->room_number, 0, 1);
                        $roomRevCount = $room->reviews ? $room->reviews->count() : 0;
                        $roomAvg = $roomRevCount > 0 ? round($room->reviews->avg('rating'), 1) : null;
                    @endphp

                    {{-- 1. Photo on Top (Completely clean, zero text overlay) --}}
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                        <img src="{{ str_starts_with($roomPhoto, 'images/') ? asset($roomPhoto) : asset('storage/' . $roomPhoto) }}" 
                             loading="lazy" decoding="async" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" 
                             alt="{{ __('messages.room') }} {{ $room->room_number }}">
                    </div>

                    {{-- 2. Card Content (Clean White Background) --}}
                    <div class="p-5 flex flex-col flex-1 justify-between">
                        <div>
                            {{-- Type & Availability Pill Row --}}
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider truncate">
                                    {{ $room->room_type ?: 'Standard' }}
                                </span>

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }} text-xs font-semibold whitespace-nowrap shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? __('messages.status_available') : __('messages.status_occupied') }}
                                </span>
                            </div>

                            {{-- Room Title --}}
                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-slate-700 transition-colors tracking-tight mb-1">
                                {{ __('messages.room') }} {{ $room->room_number }}
                            </h3>

                            {{-- Floor & Rating --}}
                            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-4">
                                <span class="text-slate-600">{{ $room->localized_zoning_badge }}</span>
                                @if($roomRevCount > 0)
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-slate-700 font-semibold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ number_format($roomAvg, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Price Bar & Action Button --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block leading-none mb-1">{{ __('messages.rental_rate') }}</span>
                                <p class="text-slate-900 font-bold text-lg tracking-tight">
                                    Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-xs font-normal text-slate-500">{{ __('messages.per_month_short') }}</span>
                                </p>
                            </div>

                            <span class="px-3 py-1.5 rounded-xl bg-slate-900 text-white group-hover:bg-slate-800 text-xs font-semibold transition-colors flex items-center gap-1 shadow-2xs">
                                <span>{{ __('messages.details') }}</span>
                                <span>&rarr;</span>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                    <p class="col-span-4 text-center text-slate-500 py-10 font-bold uppercase tracking-wider text-xs">{{ __('messages.no_rooms_available') }}</p>
                @endforelse

            </div>

        </div>
    </section>

    <!-- ============ HOUSING HIGHLIGHTS & TENTANG KAMI ============ -->
    <section id="tentang-kami" class="py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ __('messages.housing_options_title') }}</h2>
                <p class="text-slate-600 text-sm font-medium mt-1">{{ __('messages.housing_options_desc') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Info Card -->
                <div class="bg-slate-900 text-white rounded-2xl p-7 flex flex-col justify-between items-start min-h-[280px]">
                    <div>
                        <h3 class="text-2xl font-black mb-3">{{ __('messages.monthly_yearly_title') }}</h3>
                        <p class="text-slate-300 text-xs leading-relaxed font-medium">{{ __('messages.monthly_yearly_desc') }}</p>
                    </div>
                    <a href="{{ route('catalog.index') }}" class="px-6 py-2.5 bg-white text-slate-900 font-bold uppercase tracking-wider rounded-full text-xs hover:bg-slate-100 transition-colors mt-6">
                        {{ __('messages.check_room_avail') }} &rarr;
                    </a>
                </div>

                <!-- Housing Card 1: Mahasiswa -->
                <div class="relative rounded-2xl overflow-hidden min-h-[280px] shadow-sm bg-slate-900">
                    <img src="{{ asset('images/rooms/room_102.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Hunian Mahasiswa">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    <div class="absolute top-5 left-5 z-10">
                        <span class="text-xs font-bold uppercase tracking-wider bg-emerald-600 text-white px-3 py-1 rounded-full shadow-xs">{{ __('messages.students_badge') }}</span>
                    </div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3 class="text-white font-bold text-lg mb-1">{{ __('messages.students_title') }}</h3>
                        <p class="text-white/90 text-xs font-medium leading-relaxed">{{ __('messages.students_desc') }}</p>
                    </div>
                </div>

                <!-- Housing Card 2: Karyawan -->
                <div class="relative rounded-2xl overflow-hidden min-h-[280px] shadow-sm bg-slate-900">
                    <img src="{{ asset('images/rooms/room_203.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Hunian Karyawan">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    <div class="absolute top-5 left-5 z-10">
                        <span class="text-xs font-bold uppercase tracking-wider bg-indigo-600 text-white px-3 py-1 rounded-full shadow-xs">{{ __('messages.workers_badge') }}</span>
                    </div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3 class="text-white font-bold text-lg mb-1">{{ __('messages.workers_title') }}</h3>
                        <p class="text-white/90 text-xs font-medium leading-relaxed">{{ __('messages.workers_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ HOW IT WORKS ============ -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-12">
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">{{ __('messages.workflow_title') }}</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        01
                    </span>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">{{ __('messages.step1_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.step1_desc') }}</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        02
                    </span>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">{{ __('messages.step2_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.step2_desc') }}</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter shrink-0 select-none w-10">
                        03
                    </span>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">{{ __('messages.step3_title') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ __('messages.step3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
