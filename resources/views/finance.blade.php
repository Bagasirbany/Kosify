<x-app-layout>
    <div x-data="{ showExpenseModal: false }" class="bg-slate-50 min-h-screen p-6 md:p-8 animate-[fadeIn_0.5s_ease-out] font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">ARUS KAS & KEUANGAN</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Keuangan Kos</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau pembukuan kas, rekap penerimaan sewa, dan pengeluaran operasional.</p>
            </div>
            <div class="flex items-center gap-2.5 print:hidden flex-wrap">
                <a href="{{ route('finance.exportCsv') }}" class="px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-2xs">
                    EXPORT CSV / EXCEL
                </a>
                <button @click="showExpenseModal = true" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-xs">
                    + CATAT PENGELUARAN
                </button>
            </div>
        </div>

        <!-- SUMMARY CARDS (Text-First) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">TOTAL PEMASUKAN</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">KAS MASUK</span>
                </div>
                <h3 class="text-3xl font-black text-slate-900 mb-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Seluruh Pembayaran Sewa</p>
            </div>
            
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">TOTAL PENGELUARAN</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200">KAS KELUAR</span>
                </div>
                <h3 class="text-3xl font-black text-slate-900 mb-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Operasional & Perawatan</p>
            </div>

            <div class="bg-slate-900 border border-slate-900 rounded-3xl p-6 shadow-xs text-white">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">SALDO BERSIH (PROFIT)</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-white/10 text-emerald-400 border border-white/20">BERSIH</span>
                </div>
                <h3 class="text-3xl font-black mb-1">Rp {{ number_format($saldoBersih, 0, ',', '.') }}</h3>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pemasukan - Pengeluaran</p>
            </div>
        </div>

        <!-- TWO COLUMN TABLES -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- LEFT: PEMASUKAN TERBARU -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">KAS MASUK</span>
                        <h2 class="text-base font-black text-slate-900">Pemasukan Terbaru</h2>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5">PENYEWA / KAMAR</th>
                                <th class="px-5 py-3.5">TANGGAL</th>
                                <th class="px-5 py-3.5 text-right">NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse ($payments as $payment)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="font-black text-slate-900">{{ $payment->reservation->user->name ?? 'User' }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">KAMAR {{ $payment->reservation->room->room_number ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-600">{{ $payment->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-right font-black text-emerald-700">
                                    + Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-slate-400 font-bold uppercase tracking-wider text-xs">Belum ada data pembayaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- RIGHT: PENGELUARAN TERBARU -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">KAS KELUAR</span>
                        <h2 class="text-base font-black text-slate-900">Pengeluaran Operasional</h2>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5">DESKRIPSI</th>
                                <th class="px-5 py-3.5">KATEGORI</th>
                                <th class="px-5 py-3.5 text-right">NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse ($expenses as $expense)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="font-black text-slate-900">{{ $expense->title }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right font-black text-rose-700">
                                    - Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-slate-400 font-bold uppercase tracking-wider text-xs">Belum ada data pengeluaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        <!-- MODAL PENGELUARAN (Text-First) -->
        <div x-show="showExpenseModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div x-show="showExpenseModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

                <div @click.away="showExpenseModal = false" x-show="showExpenseModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="inline-block bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-slate-200 p-6 md:p-8 relative z-10">
                    <form action="{{ route('finance.storeExpense') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">CATATAN KAS KELUAR</span>
                                <h3 class="text-lg font-black text-slate-900 uppercase">Catat Pengeluaran Baru</h3>
                            </div>
                            <button type="button" @click="showExpenseModal = false" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold uppercase">
                                TUTUP
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Pengeluaran</label>
                                <input type="text" name="title" required class="w-full text-xs font-semibold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none" placeholder="Cth: Tagihan Listrik PLN / WiFi">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                                    <select name="category" required class="w-full text-xs font-bold uppercase border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none">
                                        <option value="Listrik">Listrik & Air</option>
                                        <option value="Pemeliharaan">Pemeliharaan & Perbaikan</option>
                                        <option value="Gaji Pegawai">Gaji Pegawai</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal</label>
                                    <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}" class="w-full text-xs font-bold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nominal (Rp)</label>
                                <input type="number" name="amount" required min="1" class="w-full text-xs font-bold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 text-slate-900 outline-none" placeholder="500000">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="2" class="w-full text-xs font-medium border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showExpenseModal = false" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold uppercase text-xs hover:bg-slate-50 transition-colors">
                                BATAL
                            </button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-black uppercase text-xs tracking-wider hover:bg-black transition-all shadow-xs">
                                SIMPAN PENGELUARAN &rarr;
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
