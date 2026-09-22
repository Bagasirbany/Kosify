<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto p-6 md:p-8 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">TRANSAKSI & SEWA</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Reservasi & Booking</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola permintaan sewa, verifikasi pembayaran manual, dan dokumen legalitas.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                [ SUKSES ] {{ session('success') }}
            </div>
        @endif

        @php
            $pendingCount = $bookings->filter(fn($b) => in_array($b->status, ['pending', 'waiting_verification']))->count();
            $confirmedCount = $bookings->filter(fn($b) => in_array($b->status, ['active', 'confirmed', 'paid']))->count();
            $totalIncome = $bookings->filter(fn($b) => in_array($b->status, ['active', 'confirmed', 'paid', 'completed']))->sum('total_price');
        @endphp

        <!-- Stats Grid (Text-First) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-700 block mb-2">MENUNGGU KONFIRMASI</span>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ $pendingCount }} <span class="text-sm font-bold text-slate-400">PERMINTAAN</span></h3>
                <p class="text-xs text-slate-500 font-medium">Perlu tindakan verifikasi admin</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-700 block mb-2">TERKONFIRMASI & AKTIF</span>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ $confirmedCount }} <span class="text-sm font-bold text-slate-400">HUNIAN</span></h3>
                <p class="text-xs text-slate-500 font-medium">Kamar terisi dan masa sewa berjalan</p>
            </div>

            <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2">TOTAL PENDAPATAN</span>
                <h3 class="text-2xl font-black text-white mb-1 tracking-tight">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-400 font-medium">Akumulasi seluruh booking terkonfirmasi</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-black text-slate-900">Daftar Booking Masuk ({{ $bookings->count() }})</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 font-bold">Penyewa</th>
                            <th class="py-4 px-6 font-bold">Kamar</th>
                            <th class="py-4 px-6 font-bold">Periode & Durasi</th>
                            <th class="py-4 px-6 font-bold">Total Harga</th>
                            <th class="py-4 px-6 font-bold">Status</th>
                            <th class="py-4 px-6 text-right font-bold">Aksi & Dokumen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($bookings as $b)
                            @php
                                $user = \App\Models\User::find($b->user_id);
                                $payment = $b->payments->first();
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-xs">{{ $user->name ?? 'Penyewa' }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium">{{ $user->phone ?? $user->email ?? '-' }}</div>
                                </td>

                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 text-xs block">
                                        Kamar {{ $b->room->room_number ?? '-' }}
                                    </span>
                                    <span class="text-[11px] font-medium text-slate-500">Tipe {{ ucfirst(strtolower($b->room->room_type ?? 'Standard')) }}</span>
                                </td>

                                <td class="py-4 px-6">
                                    <span class="font-semibold text-slate-900 block text-xs">
                                        {{ \Carbon\Carbon::parse($b->start_date)->format('d M Y') }}
                                    </span>
                                    <span class="text-[11px] font-medium text-slate-500 block">{{ $b->duration_months }} Bulan Sewa</span>
                                </td>

                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block text-xs">
                                        Rp {{ number_format($b->total_price, 0, ',', '.') }}
                                    </span>
                                    @if($payment && $payment->proof_of_payment_url)
                                        <a href="{{ asset('storage/' . $payment->proof_of_payment_url) }}" target="_blank" class="text-[11px] font-semibold text-blue-600 hover:underline block mt-0.5">
                                            Lihat Struk Transfer &rarr;
                                        </a>
                                    @else
                                        <span class="text-[11px] font-medium text-slate-400 block">Transfer Bank</span>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    @if($b->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($b->status === 'waiting_verification')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Verifikasi Struk
                                        </span>
                                    @elseif(in_array($b->status, ['active', 'confirmed', 'paid']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Terkonfirmasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            {{ ucfirst(strtolower($b->status)) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                                        <!-- Link Surat Kontrak & Kuitansi -->
                                        <a href="{{ route('bookings.invoice', $b->id) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                                            Kuitansi
                                        </a>
                                        <a href="{{ route('bookings.contract', $b->id) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                                            Kontrak
                                        </a>

                                        @if(in_array($b->status, ['pending', 'waiting_verification']))
                                            <form action="{{ route('bookings.updateStatus', $b->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white font-semibold text-xs rounded-xl transition-all shadow-xs cursor-pointer">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.updateStatus', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak dan batalkan booking ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs rounded-xl transition-colors border border-rose-200/60 cursor-pointer">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium text-xs">
                                    Belum ada data reservasi atau booking masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
