<x-catalog-layout>
    <div class="bg-slate-50 min-h-screen pt-12 pb-24 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-5xl mx-auto px-6 md:px-8">
            
            {{-- Header --}}
            <div class="mb-10 pb-6 border-b border-slate-200">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">PORTAL PENYEWA</span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2 tracking-tight">Booking & Reservasi Saya</h1>
                <p class="text-slate-500 font-medium text-xs">Kelola semua reservasi kamar kos, riwayat tagihan, dan unduh dokumen legalitas Anda.</p>
            </div>

            {{-- Tabs --}}
            <div x-data="{ activeTab: 'aktif', openManualModal: false, selectedBookingId: '', selectedRoomNo: '', selectedPrice: '' }" class="mb-8">
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
                                                    <span class="block text-slate-400 font-bold mb-0.5 uppercase tracking-wider text-[9px]">Check-out</span>
                                                    <span class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
                                                </div>
                                                <div>
                                                    <span class="block text-slate-400 font-bold mb-0.5 uppercase tracking-wider text-[9px]">Durasi</span>
                                                    <span class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->end_date)->diffInMonths(\Carbon\Carbon::parse($booking->start_date)) }} Bulan</span>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-auto flex flex-wrap justify-end gap-2">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6281234567890') }}?text={{ urlencode('Halo Admin Kosify, saya ' . auth()->user()->name . ' ingin konfirmasi mengenai sewa Kamar ' . ($booking->room->room_number ?? '')) }}" target="_blank" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-800 bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 transition-colors">
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

                                                @if($booking->status === 'pending')
                                                    <!-- Tombol Upload Manual -->
                                                    <button @click="openManualModal = true; selectedBookingId = '{{ $booking->id }}'; selectedRoomNo = '{{ $booking->room->room_number }}'; selectedPrice = '{{ number_format($booking->total_price, 0, ',', '.') }}'" class="px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-amber-900 bg-amber-50 border border-amber-300 rounded-xl hover:bg-amber-100 transition-colors">
                                                        UPLOAD STRUK TRANSFER
                                                    </button>

                                                    <!-- Tombol Midtrans -->
                                                    <button onclick="payBooking('{{ $booking->id }}')" class="px-4 py-2 text-xs font-black uppercase tracking-wider text-white bg-slate-900 rounded-xl hover:bg-black transition-colors shadow-xs">
                                                        BAYAR OTOMATIS
                                                    </button>
                                                @elseif($booking->status === 'waiting_verification')
                                                    <span class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-blue-800 bg-blue-50 border border-blue-200 rounded-xl">
                                                        STRUK SEDANG DIVERIFIKASI
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

                {{-- Modal Upload Transfer Manual (Text-First) --}}
                <div x-show="openManualModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
                    
                    <div @click.away="openManualModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative overflow-hidden">
                        <button @click="openManualModal = false" class="absolute top-5 right-5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-xs uppercase">TUTUP</button>
                        
                        <div class="mb-5 pb-3 border-b border-slate-100">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">METODE PEMBAYARAN</span>
                            <h3 class="text-xl font-black text-slate-900">Transfer Manual Bank</h3>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Konfirmasi sewa Kamar <span x-text="selectedRoomNo" class="font-bold text-slate-900"></span></p>
                        </div>

                        <!-- Rekening Tujuan -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 mb-5 text-xs">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px] block mb-1">REKENING RESMI PENGELOLA:</span>
                            <div class="flex justify-between items-center py-1 border-b border-slate-200">
                                <span class="font-bold text-slate-700">BANK BCA</span>
                                <span class="font-black text-slate-900 font-mono">123-456-7890 (a.n Kosify)</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-slate-200">
                                <span class="font-bold text-slate-700">BANK MANDIRI</span>
                                <span class="font-black text-slate-900 font-mono">987-654-3210 (a.n Kosify)</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="font-bold text-slate-700">BANK BRI</span>
                                <span class="font-black text-slate-900 font-mono">1122-3344-5566 (a.n Kosify)</span>
                            </div>
                        </div>

                        <!-- Form Upload -->
                        <form :action="'/booking/' + selectedBookingId + '/manual-payment'" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pemilik Rekening (Pengirim)</label>
                                <input type="text" name="sender_name" required placeholder="Contoh: Bagas Pratama" class="w-full text-xs font-semibold p-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Bank Pengirim</label>
                                <input type="text" name="bank_name" required placeholder="Contoh: BCA / Mandiri / BRI / Seabank" class="w-full text-xs font-semibold p-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Bukti Transfer (ATM / m-Banking)</label>
                                <input type="file" name="payment_proof" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-900 file:text-white hover:file:bg-black cursor-pointer">
                            </div>

                            <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all mt-3">
                                KIRIM BUKTI PEMBAYARAN &rarr;
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        function payBooking(bookingId) {
            fetch(`/payment/token/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    window.snap.pay(data.token, {
                        onSuccess: function(result){
                            window.location.href = "{{ route('bookings.my') }}";
                        },
                        onPending: function(result){
                            window.location.reload();
                        },
                        onError: function(result){
                            alert("Pembayaran gagal!");
                        }
                    });
                } else {
                    alert('Gagal mengambil token pembayaran');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada sistem.');
            });
        }
    </script>
</x-catalog-layout>
