<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Expense;

class FinanceController extends Controller
{
    public function index()
    {
        // Get latest 10 payments
        $payments = Payment::with('reservation.user', 'reservation.room')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get latest 10 expenses
        $expenses = Expense::orderBy('expense_date', 'desc')
            ->take(10)
            ->get();

        // Total calculations
        $totalPemasukan = Payment::whereIn('status', ['paid', 'verified', 'success'])->sum('amount');
        $totalPengeluaran = Expense::sum('amount');
        $saldoBersih = $totalPemasukan - $totalPengeluaran;

        return view('finance', compact('payments', 'expenses', 'totalPemasukan', 'totalPengeluaran', 'saldoBersih'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('finance.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    // Export Laporan Keuangan ke format CSV / Excel
    public function exportCsv()
    {
        $filename = 'Laporan_Keuangan_Kosify_' . date('Y-m-d_His') . '.csv';

        $payments = Payment::with(['reservation.room'])
            ->whereIn('status', ['paid', 'verified', 'success'])
            ->orderBy('created_at', 'desc')
            ->get();

        $expenses = Expense::orderBy('expense_date', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($payments, $expenses) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, ['No', 'Tanggal', 'Tipe Transaksi', 'Kategori', 'Keterangan', 'Nominal (Rp)']);

            $no = 1;
            $totalIn = 0;
            $totalOut = 0;

            // Write Payments (Pemasukan)
            foreach ($payments as $p) {
                $amount = (float) $p->amount;
                $totalIn += $amount;
                $roomNo = $p->reservation->room->room_number ?? '-';
                fputcsv($file, [
                    $no++,
                    $p->created_at->format('Y-m-d H:i'),
                    'Pemasukan (Sewa)',
                    'Pembayaran Sewa Kamar',
                    'Sewa Kamar No. ' . $roomNo . ' (ID: ' . substr($p->id, 0, 8) . ')',
                    $amount
                ]);
            }

            // Write Expenses (Pengeluaran)
            foreach ($expenses as $e) {
                $amount = (float) $e->amount;
                $totalOut += $amount;
                fputcsv($file, [
                    $no++,
                    $e->expense_date,
                    'Pengeluaran (Operasional)',
                    $e->category ?? 'Operasional',
                    $e->title . ($e->notes ? ' - ' . $e->notes : ''),
                    -$amount
                ]);
            }

            // Blank line & Summary
            fputcsv($file, []);
            fputcsv($file, ['', '', '', 'TOTAL PEMASUKAN', '', $totalIn]);
            fputcsv($file, ['', '', '', 'TOTAL PENGELUARAN', '', $totalOut]);
            fputcsv($file, ['', '', '', 'SALDO BERSIH (PROFIT)', '', $totalIn - $totalOut]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
