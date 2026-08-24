<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        // Bulanan (Array 12 bulan)
        $monthlyIncome = array_fill(1, 12, 0);
        $monthlyExpense = array_fill(1, 12, 0);

        // Fetch income
        $incomes = Payment::whereIn('status', ['paid', 'verified', 'success'])
            ->whereYear('created_at', $year)
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();

        foreach ($incomes as $inc) {
            $monthlyIncome[(int)$inc->month] = (float)$inc->total;
        }

        // Fetch expenses
        $expenses = Expense::whereYear('expense_date', $year)
            ->select(DB::raw('EXTRACT(MONTH FROM expense_date) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM expense_date)'))
            ->get();

        foreach ($expenses as $exp) {
            $monthlyExpense[(int)$exp->month] = (float)$exp->total;
        }

        // Hitung Profit
        $monthlyProfit = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyProfit[$i] = $monthlyIncome[$i] - $monthlyExpense[$i];
        }

        // Summary Tahunan
        $yearlyIncome = array_sum($monthlyIncome);
        $yearlyExpense = array_sum($monthlyExpense);
        $yearlyProfit = $yearlyIncome - $yearlyExpense;

        return view('reports', compact(
            'year',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'yearlyIncome',
            'yearlyExpense',
            'yearlyProfit'
        ));
    }
}
