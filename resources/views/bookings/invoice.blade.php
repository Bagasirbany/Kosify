<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran - INV-{{ strtoupper(substr($reservation->id, 0, 8)) }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .invoice-box {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-10 px-4 sm:px-6">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('bookings.my') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Booking Saya
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Unduh PDF
            </button>
        </div>
    </div>

    <!-- Official Invoice Paper -->
    <div class="invoice-box max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 relative overflow-hidden">
        
        <!-- Top Colored Header Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-600 via-teal-600 to-slate-900"></div>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-slate-100 pb-8 mb-8">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Kosify Logo" class="h-10 w-auto object-contain mb-3">
                <p class="text-xs text-slate-500 font-medium leading-relaxed">
                    {{ $settings['company_address'] ?? 'Pusat Hunian Kos Eksklusif & Modern' }}<br>
                    WhatsApp: {{ $settings['admin_phone'] ?? '0812-3456-7890' }} | Email: support@kosify.com
                </p>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-800 text-xs font-extrabold uppercase tracking-widest rounded-md mb-2">
                    Kuitansi Resmi
                </span>
                <h1 class="text-xl font-extrabold text-slate-900">
                    INV/KSF/{{ date('Ymd', strtotime($reservation->created_at ?? now())) }}/{{ strtoupper(substr($reservation->id, 0, 6)) }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Tanggal Terbit: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($reservation->created_at ?? now())->format('d F Y') }}</strong>
                </p>
            </div>
        </div>

        <!-- Two Columns: Customer & Booking Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8 pb-8 border-b border-slate-100 text-sm">
            <!-- Customer -->
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Diterbitkan Untuk (Penyewa):</p>
                <h3 class="font-extrabold text-slate-900 text-base">{{ $user->name }}</h3>
                <p class="text-slate-600 text-xs mt-1">{{ $user->email }}</p>
                <p class="text-slate-600 text-xs">{{ $user->phone ?? '08xxxxxxxxxx' }}</p>
                <p class="text-xs font-semibold text-emerald-700 mt-1.5 bg-emerald-50 inline-block px-2 py-0.5 rounded">
                    Status Akun: Terverifikasi
                </p>
            </div>

            <!-- Booking Details -->
            <div class="sm:text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Informasi Hunian & Sewa:</p>
                <p class="text-slate-900 font-bold">Kamar {{ $reservation->room->room_number ?? '-' }} (Tipe {{ $reservation->room->room_type ?? 'Standard' }})</p>
                <p class="text-slate-600 text-xs mt-1">
                    Check-in: <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d M Y') }}</span>
                </p>
                <p class="text-slate-600 text-xs">
                    Check-out: <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($reservation->end_date ?? \Carbon\Carbon::parse($reservation->start_date)->addMonths($reservation->duration_months))->format('d M Y') }}</span>
                </p>
                <p class="text-slate-600 text-xs">
                    Durasi: <span class="font-semibold text-slate-800">{{ $reservation->duration_months }} Bulan</span>
                </p>
            </div>
        </div>

        <!-- Table of Items -->
        <div class="mb-8">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Rincian Pembayaran:</p>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500 text-xs">
                            <th class="pb-3 font-bold uppercase">Deskripsi Item</th>
                            <th class="pb-3 font-bold uppercase text-center">Durasi</th>
                            <th class="pb-3 font-bold uppercase text-right">Tarif / Bulan</th>
                            <th class="pb-3 font-bold uppercase text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr>
                            <td class="py-4">
                                <p class="font-bold text-slate-900">Sewa Kamar Kosify No. {{ $reservation->room->room_number ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Tipe: {{ $reservation->room->room_type ?? 'Standard' }} • Termasuk fasilitas air bersih & WiFi 24 jam</p>
                            </td>
                            <td class="py-4 text-center font-semibold">{{ $reservation->duration_months }} Bulan</td>
                            <td class="py-4 text-right font-medium">Rp {{ number_format($reservation->room->price_per_month ?? ($reservation->total_price / max(1, $reservation->duration_months)), 0, ',', '.') }}</td>
                            <td class="py-4 text-right font-bold text-slate-900">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Calculation & Status Stamp -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
            <!-- Stamp / Status Badge -->
            <div class="flex items-center gap-3">
                @if(in_array(strtolower($reservation->status), ['active', 'confirmed', 'paid', 'success', 'completed']))
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-xl">
                        ✓
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Status Tagihan</span>
                        <span class="text-emerald-700 font-extrabold text-lg tracking-wider uppercase">LUNAS / TERVERIFIKASI</span>
                        <span class="block text-[11px] text-slate-500">Metode: Midtrans Online Payment</span>
                    </div>
                @else
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-black text-xl">
                        ⏱
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Status Tagihan</span>
                        <span class="text-amber-700 font-extrabold text-lg tracking-wider uppercase">MENUNGGU PEMBAYARAN</span>
                        <span class="block text-[11px] text-slate-500">Segera selesaikan via menu Booking Saya</span>
                    </div>
                @endif
            </div>

            <!-- Total -->
            <div class="text-right">
                <span class="text-xs text-slate-500 font-medium block">Total Pembayaran:</span>
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Footer Notes & Digital Signature -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-slate-100 text-xs text-slate-500">
            <div>
                <h4 class="font-bold text-slate-800 mb-1">Ketentuan Kuitansi:</h4>
                <ul class="list-disc list-inside space-y-0.5 text-slate-500">
                    <li>Kuitansi ini adalah bukti sah pembayaran sewa kamar di platform Kosify.</li>
                    <li>Simpan bukti ini untuk ditunjukkan saat proses serah terima kunci kamar.</li>
                    <li>Dilarang mengalihkan hak sewa ke pihak lain tanpa izin tertulis dari Admin.</li>
                </ul>
            </div>
            <div class="text-center sm:text-right flex flex-col items-center sm:items-end justify-end">
                <div class="border border-emerald-300 bg-emerald-50/50 rounded-xl p-3 text-center max-w-[200px]">
                    <span class="text-[10px] text-emerald-800 font-bold uppercase tracking-wider block">KOSIFY MANAGEMENT</span>
                    <span class="text-[9px] text-slate-400 block my-1">Digital Signature Verified</span>
                    <span class="text-[11px] font-extrabold text-emerald-700">TERTANDA SAH</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
