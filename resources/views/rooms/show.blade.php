<x-catalog-layout>
    <div class="bg-slate-50 min-h-screen pt-8 pb-24" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-7xl mx-auto px-6">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm font-medium text-slate-500 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </li>
                    <li>
                        <a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Katalog</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </li>
                    <li class="text-slate-900 font-bold" aria-current="page">Kamar {{ $room->room_number }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                {{-- Left Column: Image & Details --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- Main Image --}}
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-200 aspect-[16/10] relative group">
                        @if($room->photo)
                            <img src="{{ str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo) }}" alt="Kamar {{ $room->room_number }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/deluxe_single_room.jpg') }}" alt="Kamar {{ $room->room_number }}" class="w-full h-full object-cover">
                        @endif
                        
                        <div class="absolute top-6 left-6">
                            @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                                <span class="bg-white/95 backdrop-blur-md text-emerald-700 text-sm font-bold px-4 py-2 rounded-xl shadow-sm flex items-center gap-2 border border-slate-200">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="bg-white/95 backdrop-blur-md text-slate-600 text-sm font-bold px-4 py-2 rounded-xl shadow-sm flex items-center gap-2 border border-slate-200">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                    Sudah Terisi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Title & Info --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-6">
                            <div>
                                <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Kamar {{ $room->room_number }}</h1>
                                <p class="text-slate-500 font-medium flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $settings['kos_address'] ?? 'Jl. Kaliurang KM 5.2 No. 18, Caturtunggal, Sleman, D.I. Yogyakarta 55281' }}
                                </p>
                            </div>
                            <div class="text-left md:text-right">
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga Bulanan</p>
                                <p class="text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($room->price_per_month, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-slate-100 my-8">

                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-4">Deskripsi & Fasilitas</h3>
                            <div class="text-slate-600 leading-relaxed font-medium">
                                @if($room->description)
                                    <p>{{ $room->description }}</p>
                                @else
                                    <p>Kamar kos nyaman dan bersih dengan fasilitas standar untuk kenyamanan Anda. Cocok untuk mahasiswa maupun pekerja kantoran yang membutuhkan akses strategis.</p>
                                @endif
                            </div>
                            
                            {{-- Fasilitas Dummy --}}
                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">Kamar Mandi Dalam</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">WiFi Kencang</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">AC & Kipas Angin</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold text-slate-700">Kasur & Lemari</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Ulasan & Rating Penghuni --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">Ulasan & Rating Penghuni</h3>
                                <p class="text-xs text-slate-500">Testimoni asli dari penyewa yang pernah tinggal di kamar ini.</p>
                            </div>
                            <div class="flex items-center gap-3 bg-amber-50/80 px-4 py-2 rounded-2xl border border-amber-200">
                                <span class="text-amber-500 text-xl font-black">★</span>
                                <div>
                                    <span class="font-extrabold text-slate-900 text-base">{{ $averageRating ?? '5.0' }}</span>
                                    <span class="text-xs text-slate-500">/ 5.0 ({{ $totalReviews ?? 0 }} ulasan)</span>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Form Tulis Ulasan (Jika Login) --}}
                        @auth
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Tulis Ulasan Pengalaman Anda</h4>
                                <form action="{{ route('rooms.review', $room->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div class="flex items-center gap-3">
                                        <label class="text-xs font-semibold text-slate-600">Beri Rating:</label>
                                        <select name="rating" required class="text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 bg-white focus:ring-1 focus:ring-slate-900">
                                            <option value="5">★★★★★ (5 Bintang - Sangat Puas)</option>
                                            <option value="4">★★★★☆ (4 Bintang - Puas)</option>
                                            <option value="3">★★★☆☆ (3 Bintang - Cukup)</option>
                                            <option value="2">★★☆☆☆ (2 Bintang - Kurang)</option>
                                            <option value="1">★☆☆☆☆ (1 Bintang - Sangat Kurang)</option>
                                        </select>
                                    </div>
                                    <textarea name="comment" rows="2" required placeholder="Ceritakan kenyamanan, kebersihan, atau keramahan pemilik kos..." class="w-full text-xs p-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-1 focus:ring-slate-900"></textarea>
                                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @endauth

                        {{-- List Reviews --}}
                        <div class="space-y-4 pt-2">
                            @if(isset($room->reviews) && $room->reviews->count() > 0)
                                @foreach($room->reviews as $rev)
                                    <div class="border-b border-slate-100 last:border-0 pb-4">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">
                                                    {{ strtoupper(substr($rev->user->name ?? 'P', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="text-xs font-bold text-slate-900 block">{{ $rev->user->name ?? 'Penyewa Kosify' }}</span>
                                                    <span class="text-[10px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="text-amber-500 text-xs font-bold tracking-wider">
                                                @for($s = 1; $s <= 5; $s++)
                                                    {{ $s <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-xs text-slate-600 leading-relaxed pl-10">{{ $rev->comment }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    <p>Belum ada ulasan untuk kamar ini. Jadilah penyewa pertama yang memberikan ulasan!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column: Booking Box --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-200 shadow-sm sticky top-32">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight mb-2">Pesan Kamar</h3>
                        <p class="text-slate-500 font-medium text-sm mb-6">Pilih tanggal untuk melihat rincian biaya.</p>

                        @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                            {{-- We keep the reservation logic in the backend later, for now we keep the form --}}
                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5" x-data="bookingForm()">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required x-model="startDate" @change="calculate"
                                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block p-3 font-medium transition-colors">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Durasi (Bulan)</label>
                                    <select name="duration_months" required x-model="duration" @change="calculate"
                                            class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-slate-500 focus:border-slate-500 block p-3 font-medium cursor-pointer transition-colors">
                                        @for($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}">{{ $i }} Bulan</option>
                                        @endfor
                                    </select>
                                </div>

                                <div x-show="total > 0" class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3 mt-6">
                                    <div class="flex justify-between text-sm font-medium text-slate-600">
                                        <span>Rp {{ number_format($room->price_per_month, 0, ',', '.') }} x <span x-text="duration"></span> bulan</span>
                                        <span x-text="formatCurrency(subtotal)"></span>
                                    </div>
                                    <div class="flex justify-between text-sm font-medium text-slate-600">
                                        <span>Biaya Layanan</span>
                                        <span x-text="formatCurrency(serviceFee)"></span>
                                    </div>
                                    <hr class="border-slate-200 my-2">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-900">Total Pembayaran</span>
                                        <span class="text-xl font-black text-slate-900" x-text="formatCurrency(total)"></span>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3.5 px-4 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm">
                                        Lanjutkan ke Pembayaran
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl text-center">
                                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mx-auto mb-3 shadow-sm text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-1">Kamar Tidak Tersedia</h4>
                                <p class="text-sm text-slate-500 font-medium">Mohon maaf, kamar ini sedang disewa saat ini.</p>
                                <a href="{{ route('catalog.index') }}" class="mt-5 block w-full py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors">
                                    Cari Kamar Lain
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