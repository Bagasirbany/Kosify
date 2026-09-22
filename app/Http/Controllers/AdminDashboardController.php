<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Cache entire dashboard bundle for 600 seconds (10 minutes)
        // Automatically invalidated upon bookings, payments, expenses, reviews or room updates
        $dashboardData = Cache::remember('admin_dashboard_full_bundle', 600, function () {
            $currentMonth = Carbon::now()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();
            $currentYear = Carbon::now()->year;

            // 1. Single consolidated scalar query for all dashboard numbers (1 roundtrip instead of 11!)
            $stats = DB::selectOne("
                SELECT
                    (SELECT COUNT(*) FROM rooms) as total_rooms,
                    (SELECT COUNT(*) FROM rooms WHERE status IN ('occupied', 'terisi')) as occupied_rooms,
                    (SELECT COUNT(*) FROM reviews) as total_reviews,
                    (SELECT ROUND(AVG(rating), 1) FROM reviews) as avg_rating,
                    (SELECT COUNT(*) FROM users WHERE (role != 'admin' OR role IS NULL) AND created_at BETWEEN :start_month1 AND :end_month1) as penyewa_bulan_ini,
                    (SELECT COUNT(*) FROM users WHERE role != 'admin' OR role IS NULL) as total_penyewa,
                    (SELECT COUNT(*) FROM reservations WHERE status IN ('active', 'approved', 'pending')) as booking_aktif,
                    (SELECT COALESCE(SUM(amount), 0) FROM expenses) as total_pengeluaran,
                    (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status IN ('paid', 'verified', 'success') AND created_at BETWEEN :start_month2 AND :end_month2) as payment_bulan_ini,
                    (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status IN ('paid', 'verified', 'success')) as payment_total_all
            ", [
                'start_month1' => $currentMonth,
                'end_month1' => $endOfMonth,
                'start_month2' => $currentMonth,
                'end_month2' => $endOfMonth,
            ]);

            $totalPendapatan = (float) ($stats->payment_bulan_ini > 0 ? $stats->payment_bulan_ini : $stats->payment_total_all);
            $penyewaBaru = (int) ($stats->penyewa_bulan_ini > 0 ? $stats->penyewa_bulan_ini : $stats->total_penyewa);
            $bookingAktif = (int) $stats->booking_aktif;
            $totalPengeluaran = (float) $stats->total_pengeluaran;

            $totalKamar = (int) $stats->total_rooms;
            $kamarTerisi = (int) $stats->occupied_rooms;
            $kamarKosong = max(0, $totalKamar - $kamarTerisi);
            $okupansi = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100, 1) : 0;

            $totalReviews = (int) $stats->total_reviews;
            $averageRating = $totalReviews > 0 ? (float) $stats->avg_rating : null;

            // 2. Tren Performa (Bar Chart Data)
            $paymentsByMonth = DB::table('payments')
                ->whereIn('status', ['paid', 'verified', 'success'])
                ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$currentYear])
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

            // 3. Pengingat Jatuh Tempo Sewa
            $now = Carbon::now();
            $expiringLeases = Reservation::with(['room:id,room_number', 'user:id,name,phone'])
                ->whereIn('status', ['active', 'confirmed', 'paid', 'success'])
                ->take(15)
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

            // 4. Ulasan & Rating Terbaru
            $recentReviews = Review::with(['user:id,name', 'room:id,room_number'])
                ->latest()
                ->take(6)
                ->get();

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
                'expiringLeases' => $expiringLeases,
                'recentReviews' => $recentReviews,
            ];
        });

        return view('dashboard', $dashboardData);
    }
}
