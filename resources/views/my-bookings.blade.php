<x-catalog-layout>
    <div class="bg-slate-50 min-h-screen pt-12 pb-24 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-5xl mx-auto px-6 md:px-8">
            
            {{-- Header --}}
            <div class="mb-10 pb-6 border-b border-slate-200">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">PORTAL PENYEWA</span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2 tracking-tight">Booking & Reservasi Saya</h1>
                <p class="text-slate-500 font-medium text-xs">Kelola semua reservasi kamar kos, riwayat tagihan, dan unduh dokumen legalitas Anda.</p>
            </div>

            <div x-data="{ 
                activeTab: 'aktif', 
                openManualModal: false, 
                selectedBookingId: '', 
                selectedRoomNo: '', 
                selectedPrice: '',
                copiedAmount: false,
                copiedRekening: null,
                proofPreview: null,
                proofFileName: '',
                isUploadingProof: false,
                openExtendModal: false,
                extendData: {
                    id: '',
                    room_number: '',
                    end_date_formatted: '',
                    price_per_month: 0,
                    duration: 1,
                    subtotal: 0,
                    service_fee: 50000,
                    total: 0
                },
                openExtend(id, room_number, end_date_formatted, price_per_month) {
                    this.extendData.id = id;
                    this.extendData.room_number = room_number;
                    this.extendData.end_date_formatted = end_date_formatted;
                    this.extendData.price_per_month = Number(price_per_month) || 1500000;
                    this.extendData.duration = 1;
                    this.calcExtend();
                    this.openExtendModal = true;
                },
                calcExtend() {
                    this.extendData.subtotal = this.extendData.price_per_month * parseInt(this.extendData.duration);
                    this.extendData.total = this.extendData.subtotal + this.extendData.service_fee;
                },
                formatRupiah(num) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
                }
            }" 
            class="mb-8">
                <div class="flex gap-6 border-b border-slate-200">
                    <button @click="activeTab = 'aktif'" 
                            :class="{'text-slate-900 border-b-2 border-slate-900 font-black': activeTab === 'aktif', 'text-slate-400 font-bold hover:text-slate-600': activeTab !== 'aktif'}"
                            class="pb-4 px-2 text-xs uppercase tracking-wider transition-colors">
                        Reservasi Aktif
                    </button>
                    <button @click="activeTab = 'riwayat'" 
                            :class="{'text-slate-900 border-b-2 border-slate-900 font-black': activeTab === 'riwayat', 'text-slate-400 font-bold hover:text-slate-600': activeTab !== 'riwayat'}"
                            class="pb-4 px-2 text-xs uppercase tracking-wider transition-colors">
                        Riwayat Selesai
                    </button>
                </div>

                @if(session('success'))
                    <div class="mt-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                        [ SUKSES ] {{ session('success') }}
                    </div>
                @endif

                <div class="mt-8">
                    {{-- Tab: Aktif --}}
                    <div x-show="activeTab === 'aktif'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @php
                            $activeBookings = $bookings->filter(function($res) { return in_array($res->status, ['pending', 'waiting_verification', 'active', 'confirmed', 'paid']); });
                        @endphp
                        
                        @if($activeBookings->isEmpty())
                            <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center shadow-xs">
                                <span class="text-xs font-black uppercase tracking-widest text-slate-400 block mb-2">[ DATA KOSONG ]</span>
                                <h3 class="text-xl font-black text-slate-900 mb-2">Belum Ada Booking Aktif</h3>
                                <p class="text-slate-500 text-xs font-medium mb-6">Anda belum memiliki reservasi kamar kos yang sedang berjalan.</p>
                                <a href="{{ route('catalog.index') }}" class="inline-flex px-6 py-3 bg-slate-900 text-white text-xs font-black uppercase tracking-wider rounded-xl hover:bg-black transition-colors shadow-xs">
                                    CARI KAMAR KOS &rarr;
                                </a>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($activeBookings as $booking)
                                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs flex flex-col md:flex-row group hover:shadow-md transition-shadow">
                                        <div class="md:w-64 h-48 md:h-auto bg-slate-100 relative shrink-0">
                                            @php
                                                $bookingPhoto = $booking->room->photo 
                                                    ? (str_starts_with($booking->room->photo, 'http') ? $booking->room->photo : (str_starts_with($booking->room->photo, 'images/') ? asset($booking->room->photo) : asset('storage/' . $booking->room->photo)))
                                                    : asset('images/deluxe_single_room.jpg');
                                            @endphp
                                            <img src="{{ $bookingPhoto }}" alt="Kamar" class="w-full h-full object-cover">
                                            
                                            <div class="absolute top-4 left-4">
                                                @if($booking->status === 'pending')
                                                    <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">MENUNGGU BAYAR</span>
                                                @elseif($booking->status === 'waiting_verification')
                                                    <span class="bg-blue-100 text-blue-900 border border-blue-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">VERIFIKASI STRUK</span>
                                                @elseif(in_array($booking->status, ['active', 'confirmed', 'paid']))
                                                    <span class="bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">LUNAS / AKTIF</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="p-6 md:p-8 flex-1 flex flex-col">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">ID: #{{ substr($booking->id, 0, 8) }}</span>
                                                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Kamar {{ $booking->room->room_number }}</h3>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-0.5">TOTAL TAGIHAN</span>
                                                    <p class="text-xl font-black text-slate-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                                <div>
                                                    <span class="block text-slate-400 font-bold mb-0.5 uppercase tracking-wider text-[9px]">Check-in</span>
                                                    <span class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</span>
                                                </div>
                                                <div>
                                                    <span class="block text-slate-400 font-bold mb-0.5 uppercase tracking-wider text-[9px]">Check-out (Tenggat Waktu)</span>
                                                    <span class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
                                                </div>
                                                <div>
                                                    <span class="block text-slate-400 font-bold mb-0.5 uppercase tracking-wider text-[9px]">Durasi</span>
                                                    <span class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->end_date)->diffInMonths(\Carbon\Carbon::parse($booking->start_date)) }} Bulan</span>
                                                </div>
                                            </div>

                                            @php
                                                $endDate = \Carbon\Carbon::parse($booking->end_date);
                                                $now = \Carbon\Carbon::now()->startOfDay();
                                                $daysLeft = (int) $now->diffInDays($endDate, false);
                                                $isExpiringSoon = $daysLeft <= 14;
                                                $isExpired = $daysLeft < 0;
                                                $roomPrice = $booking->room->price_per_month ?? 1500000;
                                                $roomNumber = $booking->room->room_number ?? '-';
                                                $endDateFormatted = $endDate->translatedFormat('d F Y');
                                            @endphp

                                            {{-- SISTEM PERINGATAN WAKTU AKAN HABIS & TENGGAT WAKTU --}}
                                            @if(in_array($booking->status, ['active', 'confirmed', 'paid']))
                                                <div class="mb-6 p-4 sm:p-5 rounded-2xl border {{ $isExpired ? 'bg-rose-50/80 border-rose-200 text-rose-950' : ($isExpiringSoon ? 'bg-amber-50/80 border-amber-200 text-amber-950' : 'bg-slate-50 border-slate-200 text-slate-900') }}">
                                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b {{ $isExpired ? 'border-rose-200' : ($isExpiringSoon ? 'border-amber-200' : 'border-slate-200') }}">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $isExpired ? 'bg-rose-600 text-white' : ($isExpiringSoon ? 'bg-amber-500 text-white' : 'bg-slate-900 text-white') }}">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <span class="text-[9px] font-black uppercase tracking-widest block {{ $isExpired ? 'text-rose-600' : ($isExpiringSoon ? 'text-amber-700' : 'text-slate-500') }}">
                                                                    @if($isExpired)
                                                                        [ PERINGATAN KRUSIAL: MASA SEWA TELAH BERAKHIR ]
                                                                    @elseif($isExpiringSoon)
                                                                        [ PERINGATAN: MASA SEWA SEGERA HABIS ]
                                                                    @else
                                                                        [ STATUS & TENGGAT WAKTU SEWA ]
                                                                    @endif
                                                                </span>
                                                                <h4 class="text-sm font-black tracking-tight">
                                                                    Tenggat Waktu: {{ $endDateFormatted }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center sm:justify-end">
                                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black {{ $isExpired ? 'bg-rose-200 text-rose-900' : ($isExpiringSoon ? 'bg-amber-200 text-amber-950' : 'bg-emerald-100 text-emerald-800') }}">
                                                                <span class="w-1.5 h-1.5 rounded-full {{ $isExpired ? 'bg-rose-600' : ($isExpiringSoon ? 'bg-amber-600 animate-ping' : 'bg-emerald-600') }}"></span>
                                                                @if($isExpired)
                                                                    Lewat {{ abs($daysLeft) }} Hari
                                                                @elseif($daysLeft == 0)
                                                                    Tenggat Waktu Berakhir Hari Ini!
                                                                @else
                                                                    Sisa {{ $daysLeft }} Hari Lagi
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- Pilihan Keputusan: Perpanjang atau Tidak Perpanjang --}}
                                                    <div class="mt-4">
                                                        @if($booking->extension_decision === 'will_checkout')
                                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200">
                                                                <div class="flex items-start gap-2.5">
                                                                    <svg class="w-4 h-4 text-slate-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                                    </svg>
                                                                    <div>
                                                                        <p class="text-xs font-black text-slate-900 uppercase tracking-wide">Pilihan Anda: Selesai Sewa (Tidak Memperpanjang)</p>
                                                                        <p class="text-[11px] text-slate-600 mt-0.5">Anda dijadwalkan checkout pada <strong>{{ $endDateFormatted }}</strong>. Silakan hubungi pemilik kos untuk pengembalian kunci.</p>
                                                                    </div>
                                                                </div>
                                                                <button type="button" @click="openExtend('{{ $booking->id }}', '{{ $roomNumber }}', '{{ $endDateFormatted }}', {{ $roomPrice }})" class="shrink-0 text-[11px] font-black uppercase tracking-wider text-slate-900 underline hover:text-black cursor-pointer">
                                                                    Ubah ke Perpanjang
                                                                </button>
                                                            </div>
                                                        @elseif($booking->extension_decision === 'extended')
                                                            <div class="flex items-start gap-2.5 bg-white p-3.5 rounded-xl border border-emerald-300">
                                                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <div>
                                                                    <p class="text-xs font-black text-emerald-900 uppercase tracking-wide">Pilihan Anda: Perpanjangan Sewa Telah Diajukan</p>
                                                                    <p class="text-[11px] text-emerald-700 mt-0.5">{{ $booking->extension_notes ?? 'Silakan lakukan pembayaran pada tagihan perpanjangan baru di daftar reservasi.' }}</p>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3.5 bg-white p-4 rounded-xl border border-slate-200">
                                                                <div>
                                                                    <p class="text-xs font-black text-slate-900">Keputusan Perpanjangan Masa Sewa</p>
                                                                    <p class="text-[11px] text-slate-500">Pilih apakah Anda ingin memperpanjang masa sewa atau mengakhiri sewa saat tenggat waktu.</p>
                                                                </div>
                                                                <div class="flex items-center gap-2 shrink-0">
                                                                    {{-- Form Tidak Perpanjang --}}
                                                                    <form action="{{ route('bookings.terminate', $booking->id) }}" method="POST" onsubmit="return confirm('Konfirmasi: Anda yakin memilih TIDAK MEMPERPANJANG sewa dan akan checkout pada {{ $endDateFormatted }}?')">
                                                                        @csrf
                                                                        <button type="submit" class="px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-xl transition-colors cursor-pointer">
                                                                            Tidak Perpanjang
                                                                        </button>
                                                                    </form>

                                                                    {{-- Tombol Perpanjang Sewa --}}
                                                                    <button type="button" @click="openExtend('{{ $booking->id }}', '{{ $roomNumber }}', '{{ $endDateFormatted }}', {{ $roomPrice }})" class="px-4 py-2 text-xs font-black uppercase tracking-wider text-white bg-slate-900 hover:bg-black rounded-xl transition-colors shadow-xs flex items-center gap-1.5 cursor-pointer">
                                                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                        </svg>
                                                                        <span>Perpanjang Sewa</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <div class="mt-auto flex flex-wrap justify-end gap-2">
                                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6285815721534')) }}?text={{ urlencode('Halo Mas Bagas Irbany, saya ' . auth()->user()->name . ' ingin konfirmasi mengenai sewa Kamar ' . ($booking->room->room_number ?? '')) }}" target="_blank" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-800 bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 transition-colors">
                                                    CHAT WA OWNER
                                                </a>

                                                <a href="{{ route('bookings.contract', $booking->id) }}" target="_blank" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-800 bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 transition-colors">
                                                    SURAT KONTRAK (PDF)
                                                </a>

                                                <a href="{{ route('bookings.invoice', $booking->id) }}" target="_blank" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-800 bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 transition-colors">
                                                    KUITANSI (PDF)
                                                </a>

                                                <a href="{{ route('rooms.detail', $booking->room->id) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-800 bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 transition-colors">
                                                    LIHAT KAMAR
                                                </a>

                                                @if(in_array($booking->status, ['pending', 'waiting_verification']))
                                                    <!-- Tombol Batalkan Pesanan -->
                                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Konfirmasi: Anda yakin ingin membatalkan pesanan Kamar {{ $booking->room->room_number ?? '' }} ini?')" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-100 hover:border-rose-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            <span>BATALKAN PESANAN</span>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($booking->status === 'pending')
                                                    <!-- Tombol Bayar Transfer & Upload Manual -->
                                                    <button id="btn-manual-{{ $booking->id }}" 
                                                            @click="openManualModal = true; selectedBookingId = '{{ $booking->id }}'; selectedRoomNo = '{{ $booking->room->room_number }}'; selectedPrice = '{{ number_format($booking->total_price, 0, ',', '.') }}'" 
                                                            class="px-4 py-2 text-xs font-black uppercase tracking-wider text-white bg-slate-900 rounded-xl hover:bg-black transition-colors shadow-xs flex items-center gap-2 cursor-pointer group">
                                                        <svg class="w-3.5 h-3.5 text-emerald-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                        <span>BAYAR VIA TRANSFER & UNGGAH STRUK</span>
                                                    </button>
                                                @elseif($booking->status === 'waiting_verification')
                                                    <span class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-1.5">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                        <span>STRUK SEDANG DIVERIFIKASI</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Tab: Riwayat --}}
                    <div x-show="activeTab === 'riwayat'" x-cloak>
                        @php
                            $historyBookings = $bookings->filter(function($res) { return in_array($res->status, ['completed', 'cancelled']); });
                        @endphp
                        
                        @if($historyBookings->isEmpty())
                            <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center shadow-xs">
                                <p class="text-slate-500 font-bold uppercase tracking-wider text-xs">Belum ada riwayat booking selesai atau batal.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($historyBookings as $booking)
                                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between shadow-xs">
                                        <div>
                                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">ID: #{{ substr($booking->id, 0, 8) }}</span>
                                            <h4 class="font-black text-slate-900 text-base">Kamar {{ $booking->room->room_number }}</h4>
                                            <p class="text-xs text-slate-500 font-medium">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="text-right flex flex-col items-end gap-1">
                                            <p class="font-black text-slate-900 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                            @if($booking->status === 'completed')
                                                <span class="bg-slate-100 text-slate-700 border border-slate-300 text-[10px] font-black px-2.5 py-0.5 rounded uppercase tracking-wider">SELESAI</span>
                                            @else
                                                <span class="bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-black px-2.5 py-0.5 rounded uppercase tracking-wider">DIBATALKAN</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Modal Perpanjang Sewa (Resmi & Terintegrasi) --}}
                <div x-show="openExtendModal" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" 
                     style="display: none;">
                    
                    <div @click.away="openExtendModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[92vh] overflow-y-auto">
                        
                        {{-- Close Button --}}
                        <button type="button" @click="openExtendModal = false" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        {{-- Header Modal --}}
                        <div class="mb-5 pb-4 border-b border-slate-100 pr-8">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider mb-2">
                                Form Perpanjangan Sewa
                            </span>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Perpanjang Kamar <span x-text="extendData.room_number"></span></h3>
                            <p class="text-slate-500 text-xs font-medium mt-1">
                                Masa sewa baru dimulai langsung setelah tenggat waktu: <strong class="text-slate-800" x-text="extendData.end_date_formatted"></strong>
                            </p>
                        </div>

                        <form :action="'/booking/' + extendData.id + '/extend'" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Durasi Perpanjangan</label>
                                <select name="duration_months" x-model="extendData.duration" @change="calcExtend()" class="w-full text-xs font-bold px-3.5 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none transition-all cursor-pointer">
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan (1 Tahun)</option>
                                </select>
                            </div>

                            {{-- Rincian Biaya --}}
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2.5 text-xs">
                                <div class="flex justify-between font-medium text-slate-600">
                                    <span>Sewa Kamar (<span x-text="extendData.duration"></span> bln)</span>
                                    <span class="font-bold text-slate-800" x-text="formatRupiah(extendData.subtotal)"></span>
                                </div>
                                <div class="flex justify-between font-medium text-slate-600">
                                    <span>Biaya Layanan & Pemeliharaan</span>
                                    <span class="font-bold text-slate-800">Rp 50.000</span>
                                </div>
                                <hr class="border-slate-200 my-1">
                                <div class="flex justify-between items-baseline pt-1">
                                    <span class="font-black text-slate-900 uppercase tracking-wide text-xs">Total Pembayaran</span>
                                    <span class="text-base font-black text-slate-900" x-text="formatRupiah(extendData.total)"></span>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Setelah klik konfirmasi, silakan lakukan pembayaran via transfer bank dan unggah bukti transfer di menu reservasi ini.
                            </p>

                            <div class="pt-2 space-y-2">
                                <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <span>KONFIRMASI PERPANJANGAN SEWA</span>
                                    <span>&rarr;</span>
                                </button>
                                <button type="button" @click="openExtendModal = false" class="w-full py-2.5 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider rounded-xl border border-slate-200 transition-colors cursor-pointer">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Upload Transfer Manual (Modern Professional) --}}
                <div x-show="openManualModal" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" 
                     style="display: none;">
                    
                    <div @click.away="openManualModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[92vh] overflow-y-auto">
                        
                        {{-- Close Button --}}
                        <button type="button" @click="openManualModal = false; proofPreview = null; proofFileName = '';" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        {{-- Header Modal --}}
                        <div class="mb-5 pb-4 border-b border-slate-100 pr-10">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider mb-2">
                                Transfer Bank Manual
                            </span>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Instruksi Pembayaran</h3>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Selesaikan sewa untuk unit <strong class="text-slate-900">Kamar <span x-text="selectedRoomNo"></span></strong></p>
                        </div>

                        {{-- Total Amount Banner --}}
                        <div class="bg-slate-900 text-white rounded-2xl p-4 mb-5 flex items-center justify-between shadow-xs">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">TOTAL TAGIHAN</span>
                                <span class="text-2xl font-black tracking-tight" x-text="'Rp ' + selectedPrice"></span>
                            </div>
                            <button type="button" 
                                    @click="navigator.clipboard.writeText(selectedPrice.replace(/\./g, '')); copiedAmount = true; setTimeout(() => copiedAmount = false, 2000)" 
                                    class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold flex items-center gap-1.5 transition-colors border border-white/10">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span x-text="copiedAmount ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>

                        {{-- Rekening Resmi Pengelola --}}
                        <div class="space-y-2 mb-5">
                            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block">Pilih Rekening Tujuan Pengelola:</span>
                            
                            {{-- BCA --}}
                            <div class="p-3 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200/80 flex items-center justify-between transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2.5 py-1 rounded bg-blue-600 text-white font-black text-[10px] tracking-wide">BCA</span>
                                    <div>
                                        <span class="font-mono font-black text-slate-900 text-sm">123-456-7890</span>
                                        <span class="text-[10px] text-slate-500 font-medium block">a.n Kosify Official</span>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="navigator.clipboard.writeText('1234567890'); copiedRekening = 'bca'; setTimeout(() => copiedRekening = null, 2000)" 
                                        class="px-3 py-1 rounded-lg text-xs font-bold transition-all"
                                        :class="copiedRekening === 'bca' ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-700 hover:bg-slate-200 border border-slate-200'">
                                    <span x-text="copiedRekening === 'bca' ? 'Tersalin' : 'Salin'"></span>
                                </button>
                            </div>

                            {{-- Mandiri --}}
                            <div class="p-3 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200/80 flex items-center justify-between transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2.5 py-1 rounded bg-amber-500 text-white font-black text-[10px] tracking-wide">MANDIRI</span>
                                    <div>
                                        <span class="font-mono font-black text-slate-900 text-sm">987-654-3210</span>
                                        <span class="text-[10px] text-slate-500 font-medium block">a.n Kosify Official</span>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="navigator.clipboard.writeText('9876543210'); copiedRekening = 'mandiri'; setTimeout(() => copiedRekening = null, 2000)" 
                                        class="px-3 py-1 rounded-lg text-xs font-bold transition-all"
                                        :class="copiedRekening === 'mandiri' ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-700 hover:bg-slate-200 border border-slate-200'">
                                    <span x-text="copiedRekening === 'mandiri' ? 'Tersalin' : 'Salin'"></span>
                                </button>
                            </div>

                            {{-- BRI --}}
                            <div class="p-3 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200/80 flex items-center justify-between transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2.5 py-1 rounded bg-blue-700 text-white font-black text-[10px] tracking-wide">BRI</span>
                                    <div>
                                        <span class="font-mono font-black text-slate-900 text-sm">1122-3344-5566</span>
                                        <span class="text-[10px] text-slate-500 font-medium block">a.n Kosify Official</span>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="navigator.clipboard.writeText('112233445566'); copiedRekening = 'bri'; setTimeout(() => copiedRekening = null, 2000)" 
                                        class="px-3 py-1 rounded-lg text-xs font-bold transition-all"
                                        :class="copiedRekening === 'bri' ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-700 hover:bg-slate-200 border border-slate-200'">
                                    <span x-text="copiedRekening === 'bri' ? 'Tersalin' : 'Salin'"></span>
                                </button>
                            </div>
                        </div>

                        {{-- Form Upload Bukti --}}
                        <form :action="'/booking/' + selectedBookingId + '/manual-payment'" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              @submit="isUploadingProof = true" 
                              class="space-y-4 pt-2 border-t border-slate-100">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Bank Pengirim</label>
                                    <select name="bank_name" required class="w-full text-xs font-semibold px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none transition-all">
                                        <option value="" disabled selected>Pilih Bank Anda...</option>
                                        <option value="BCA">Bank BCA</option>
                                        <option value="Mandiri">Bank Mandiri</option>
                                        <option value="BRI">Bank BRI</option>
                                        <option value="BNI">Bank BNI</option>
                                        <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                                        <option value="CIMB Niaga">CIMB Niaga</option>
                                        <option value="Bank Jago">Bank Jago</option>
                                        <option value="Seabank">Seabank</option>
                                        <option value="Lainnya">Bank Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pemilik Rekening</label>
                                    <input type="text" name="sender_name" required placeholder="Nama di mutasi rekening" class="w-full text-xs font-semibold px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none transition-all">
                                </div>
                            </div>

                            {{-- Modern File Upload Dropzone --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Bukti Transfer (ATM / m-Banking)</label>
                                
                                {{-- Hidden Native Input --}}
                                <input type="file" 
                                       id="manual_payment_proof" 
                                       name="payment_proof" 
                                       accept="image/png,image/jpeg,image/jpg,image/webp" 
                                       required 
                                       class="hidden"
                                       @change="
                                           const f = $event.target.files[0];
                                           if (f) {
                                               proofFileName = f.name;
                                               const reader = new FileReader();
                                               reader.onload = (e) => proofPreview = e.target.result;
                                               reader.readAsDataURL(f);
                                           }
                                       ">

                                {{-- Dropzone Area --}}
                                <template x-if="!proofPreview">
                                    <div @click="document.getElementById('manual_payment_proof').click()" 
                                         class="border-2 border-dashed border-slate-200 hover:border-slate-400 bg-slate-50/60 hover:bg-slate-50 rounded-2xl p-5 text-center cursor-pointer transition-all flex flex-col items-center justify-center gap-2 group">
                                        <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-slate-800 shadow-2xs">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-slate-800 block">Klik untuk memilih bukti transfer</span>
                                            <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Format JPG, PNG, atau WEBP (Maksimal 3 MB)</span>
                                        </div>
                                    </div>
                                </template>

                                {{-- File Preview Area --}}
                                <template x-if="proofPreview">
                                    <div class="p-3 bg-emerald-50/60 border border-emerald-200 rounded-2xl flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <img :src="proofPreview" class="w-12 h-12 rounded-xl object-cover border border-emerald-200 shrink-0" alt="Preview Bukti">
                                            <div class="truncate">
                                                <span class="text-xs font-bold text-slate-900 block truncate" x-text="proofFileName"></span>
                                                <span class="text-[10px] font-bold text-emerald-700 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-emerald-600 inline shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Foto siap dikirim
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button" @click="document.getElementById('manual_payment_proof').click()" class="shrink-0 px-3 py-1.5 rounded-lg bg-white text-slate-700 hover:bg-slate-100 text-xs font-bold border border-slate-200 transition-colors">
                                            Ganti
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <button type="submit" 
                                    :disabled="isUploadingProof" 
                                    class="w-full py-3.5 bg-slate-900 hover:bg-black disabled:bg-slate-400 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mt-2">
                                <span x-show="!isUploadingProof">KIRIM BUKTI PEMBAYARAN &rarr;</span>
                                <span x-show="isUploadingProof" class="flex items-center gap-2" style="display: none;">
                                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span>MENGUNGGAH BUKTI...</span>
                                </span>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @if(session('auto_open_manual'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const triggerBtn = document.getElementById('btn-manual-{{ session('auto_open_manual') }}');
                if (triggerBtn) {
                    triggerBtn.click();
                }
            }, 300);
        });
    </script>
    @endif
</x-catalog-layout>
