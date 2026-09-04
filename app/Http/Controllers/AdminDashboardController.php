<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $dashboardData = Cache::remember('admin_dashboard_metrics', 60, function () {
            $currentMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // 1. Total Pendapatan (Bulan Ini)
            $totalPendapatan = Payment::whereIn('status', ['paid', 'verified', 'success'])
                ->whereBetween('created_at', [$currentMonth, $endOfMonth])
                ->sum('amount');

            if ($totalPendapatan == 0) {
                $totalPendapatan = Payment::whereIn('status', ['paid', 'verified', 'success'])->sum('amount');
            }

            // 2. Penyewa Baru
            $penyewaBaru = User::where(function($q) {
                    $q->where('role', '!=', 'admin')->orWhereNull('role');
                })
                ->whereBetween('created_at', [$currentMonth, $endOfMonth])
                ->count();
                
            if ($penyewaBaru == 0) {
                $penyewaBaru = User::where(function($q) {
                    $q->where('role', '!=', 'admin')->orWhereNull('role');
                })->count();
            }

            // 3. Booking Aktif
            $bookingAktif = Reservation::whereIn('status', ['active', 'approved', 'pending'])->count();

            // 4. Pengeluaran
            $totalPengeluaran = Expense::sum('amount');

            // 5. Tingkat Okupansi
            $totalKamar = Room::count();
            $kamarTerisi = Room::where('status', 'occupied')->orWhere('status', 'terisi')->count();
            $kamarKosong = $totalKamar - $kamarTerisi;
            $okupansi = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100, 1) : 0;

            // 6. Tren Performa (Bar Chart Data)
            $currentYear = Carbon::now()->year;
            $paymentsByMonth = Payment::whereIn('status', ['paid', 'verified', 'success'])
                ->whereYear('created_at', $currentYear)
                ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), DB::raw('SUM(amount) as total'))
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->pluck('total', 'month')
                ->toArray();

            $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            $chartData = [];
            $maxAmount = !empty($paymentsByMonth) && max($paymentsByMonth) > 0 ? max($paymentsByMonth) : 1;
            
            foreach ($months as $index => $monthName) {
                $monthNum = $index + 1;
                $amount = $paymentsByMonth[$monthNum] ?? 0;
                $percentage = $amount > 0 ? round(($amount / $maxAmount) * 100) : 5;
                $chartData[$monthName] = $percentage;
            }

            // 7. Rating & Ulasan Penghuni
            $averageRating = \App\Models\Review::count() > 0 ? round(\App\Models\Review::avg('rating'), 1) : 5.0;
            $totalReviews = \App\Models\Review::count();

            return [
                'totalPendapatan' => $totalPendapatan,
                'penyewaBaru' => $penyewaBaru,
                'bookingAktif' => $bookingAktif,
                'totalPengeluaran' => $totalPengeluaran,
                'okupansi' => $okupansi,
                'kamarTerisi' => $kamarTerisi,
                'kamarKosong' => $kamarKosong,
                'totalKamar' => $totalKamar,
                'chartData' => $chartData,
                'averageRating' => $averageRating,
                'totalReviews' => $totalReviews,
            ];
        });

        // 8. Pengingat Jatuh Tempo Sewa (Realtime calculation)
        $now = Carbon::now();
        $expiringLeases = Reservation::with(['room', 'user'])
            ->whereIn('status', ['active', 'confirmed', 'paid', 'success'])
            ->get()
            ->map(function ($res) use ($now) {
                $startDate = Carbon::parse($res->start_date);
                $endDate = $res->end_date ? Carbon::parse($res->end_date) : $startDate->copy()->addMonths($res->duration_months ?: 1);
                $daysLeft = $now->diffInDays($endDate, false);
                
                $res->tenant_name = $res->user->name ?? 'Penyewa';
                $res->tenant_phone = $res->user->phone ?? '081234567890';
                $res->calculated_end_date = $endDate;
                $res->days_left = (int) ceil($daysLeft);
                
                return $res;
            })
            ->filter(function ($res) {
                return $res->days_left <= 7;
            })
            ->sortBy('days_left')
            ->values();

        // 9. Ulasan & Rating Terbaru
        $recentReviews = \App\Models\Review::with(['user', 'room'])->latest()->take(6)->get();

        return view('dashboard', array_merge($dashboardData, [
            'expiringLeases' => $expiringLeases,
            'recentReviews' => $recentReviews,
        ]));
    }
}
