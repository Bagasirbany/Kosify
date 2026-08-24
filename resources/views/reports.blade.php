<x-app-layout>
    <div class="bg-slate-50 min-h-screen p-6 animate-[fadeIn_0.5s_ease-out] font-sans">
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Laporan & Analitik</h1>
                <p class="text-sm text-slate-500 mt-1">Laporan tahunan pendapatan dan profit kos Anda</p>
            </div>
            
            <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-3 print:hidden">
                <select name="year" onchange="this.form.submit()" class="text-sm font-bold border-slate-200 rounded-lg bg-white text-slate-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
                <button type="button" onclick="window.print()" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF
                </button>
            </form>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] rounded-xl p-6">
                <span class="text-sm font-semibold text-slate-500">Total Pemasukan ({{ $year }})</span>
                <h3 class="text-3xl font-black text-slate-800 mt-2">Rp {{ number_format($yearlyIncome, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] rounded-xl p-6">
                <span class="text-sm font-semibold text-slate-500">Total Pengeluaran ({{ $year }})</span>
                <h3 class="text-3xl font-black text-slate-800 mt-2">Rp {{ number_format($yearlyExpense, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-blue-600 border border-blue-600 shadow-[0_4px_15px_-3px_rgba(37,99,235,0.4)] rounded-xl p-6 text-white">
                <span class="text-sm font-semibold text-blue-100">Total Profit ({{ $year }})</span>
                <h3 class="text-3xl font-black mt-2">Rp {{ number_format($yearlyProfit, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- MAIN TABLE REPORT -->
        <div class="bg-white border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] rounded-xl overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800">Rincian Laporan Bulanan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-400 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Bulan</th>
                            <th class="px-6 py-4 text-right">Pemasukan</th>
                            <th class="px-6 py-4 text-right">Pengeluaran</th>
                            <th class="px-6 py-4 text-right">Profit Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        @foreach ($months as $num => $monthName)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $monthName }}</td>
                            <td class="px-6 py-4 text-right font-medium text-emerald-600">
                                Rp {{ number_format($monthlyIncome[$num], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-red-500">
                                Rp {{ number_format($monthlyExpense[$num], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-black {{ $monthlyProfit[$num] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                Rp {{ number_format($monthlyProfit[$num], 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                        
                        <!-- TOTAL ROW -->
                        <tr class="bg-slate-50 border-t-2 border-slate-200">
                            <td class="px-6 py-4 font-black text-slate-800 uppercase">TOTAL TAHUN INI</td>
                            <td class="px-6 py-4 text-right font-black text-emerald-600">
                                Rp {{ number_format($yearlyIncome, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-red-500">
                                Rp {{ number_format($yearlyExpense, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-black {{ $yearlyProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                Rp {{ number_format($yearlyProfit, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>