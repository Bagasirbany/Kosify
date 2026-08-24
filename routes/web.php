<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kosify Application
|--------------------------------------------------------------------------
*/

// Halaman utama / Landing Page
Route::get('/', function () {
    $popularRooms = \Illuminate\Support\Facades\Cache::remember('home_popular_rooms', 120, function () {
        return \App\Models\Room::where('status', 'available')->latest()->take(4)->get();
    });
    $settings = \Illuminate\Support\Facades\Cache::remember('web_settings_all', 300, function () {
        return \App\Models\WebSetting::pluck('value', 'key')->toArray();
    });
    return view('welcome', compact('popularRooms', 'settings'));
})->name('home');

use App\Http\Controllers\RoomController;

// Katalog Kamar
Route::get('/catalog', [RoomController::class, 'catalog'])->name('catalog.index');

// Filter Lanjutan Katalog
Route::get('/katalog-filter', function () {
    return view('katalog_fiturlanjut');
})->name('catalog.filter');

// Detail Kos (Public)
Route::get('/kos/{room}', [RoomController::class, 'show'])->name('rooms.detail');

// Galeri Foto Kos
Route::get('/kos/{room}/photos', function ($room) {
    return view('rooms.gallery', ['room' => \App\Models\Room::findOrFail($room)]);
})->name('rooms.gallery');

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ReportController;

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manage Feedbacks
    Route::get('/feedbacks', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::delete('/feedbacks/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedbacks.destroy');

    // Web Settings
    Route::get('/settings', [\App\Http\Controllers\WebSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\WebSettingController::class, 'update'])->name('settings.update');

    // Admin: Manajemen Penyewa
    Route::get('/penyewa', [TenantController::class, 'index'])->name('tenants.index');
    Route::post('/penyewa', [TenantController::class, 'store'])->name('tenants.store');

    // Admin: Keuangan
    Route::get('/keuangan', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance', fn() => redirect()->route('finance.index'));
    Route::post('/keuangan/pengeluaran', [FinanceController::class, 'storeExpense'])->name('finance.storeExpense');

    // Admin: Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');

    // Admin: Manajemen Kamar
    Route::get('/kamar', [RoomController::class, 'adminIndex'])->name('rooms.index');
    Route::post('/kamar/sync-status', [RoomController::class, 'syncExpiredStatus'])->name('rooms.syncStatus');
    Route::get('/kamar/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/kamar', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/kamar/{id}', [RoomController::class, 'adminShow'])->name('rooms.show');
    Route::get('/kamar/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/kamar/{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/kamar/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Admin: Kelola Booking
    Route::get('/booking', [ReservationController::class, 'adminIndex'])->name('bookings.index');
    Route::patch('/booking/{id}/status', [ReservationController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::post('/booking/{id}/terminate', [ReservationController::class, 'terminateContract'])->name('bookings.terminate');

    // Admin: Keluhan & Kendala Fasilitas
    Route::get('/admin/complaints', [\App\Http\Controllers\ComplaintController::class, 'adminIndex'])->name('admin.complaints.index');
    Route::patch('/admin/complaints/{id}', [\App\Http\Controllers\ComplaintController::class, 'adminUpdateStatus'])->name('admin.complaints.update');

    // Admin: Export Keuangan CSV
    Route::get('/keuangan/export-csv', [\App\Http\Controllers\FinanceController::class, 'exportCsv'])->name('finance.exportCsv');
});


Route::middleware('auth')->group(function () {
    // User/Tenant: Riwayat Booking Saya
    Route::get('/my-bookings', [ReservationController::class, 'myBookings'])->name('bookings.my');

    // User/Tenant: Lapor Kendala Fasilitas
    Route::get('/complaints', [\App\Http\Controllers\ComplaintController::class, 'index'])->name('complaints.index');
    Route::post('/complaints', [\App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store');

    // User/Tenant: Submit Review Kamar
    Route::post('/rooms/{room}/review', [\App\Http\Controllers\RoomController::class, 'storeReview'])->name('rooms.review');

    // User/Tenant: Checkout / Reservasi
    Route::get('/booking/{room}/checkout', [ReservationController::class, 'create'])->name('bookings.checkout');
    Route::post('/booking', [ReservationController::class, 'store'])->name('bookings.store');

    // Pengaturan Akun
    Route::get('/account-settings', function () {
        return view('account-settings');
    })->name('account.settings');

    // User Profile Actions (Laravel Breeze / standard)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Integration
    Route::post('/payment/token/{reservation}', [\App\Http\Controllers\PaymentController::class, 'getSnapToken'])->name('payment.token');
    Route::post('/payment/finish/{reservation}', [\App\Http\Controllers\PaymentController::class, 'finishPayment'])->name('payment.finish');
    Route::post('/payment/fail/{reservation}', [\App\Http\Controllers\PaymentController::class, 'failPayment'])->name('payment.fail');

    // Official Invoice PDF / Print
    Route::get('/booking/{reservation}/invoice', [ReservationController::class, 'invoice'])->name('bookings.invoice');

    // Official Lease Agreement / Surat Kontrak PDF
    Route::get('/booking/{reservation}/contract', [ReservationController::class, 'contract'])->name('bookings.contract');

    // Manual Bank Transfer Confirmation Upload
    Route::post('/booking/{reservation}/manual-payment', [ReservationController::class, 'uploadManualPayment'])->name('bookings.manualPayment');
});

// Midtrans Webhook Notification Handlers (Without Auth Middleware)
Route::post('/payment/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');
Route::post('/midtrans/callback', [\App\Http\Controllers\PaymentController::class, 'webhook']);
Route::post('/api/midtrans-callback', [\App\Http\Controllers\PaymentController::class, 'webhook']);

// Chatbot Route
Route::post('/chatbot/message', [\App\Http\Controllers\ChatbotController::class, 'respond'])->name('chatbot.message');

// Setup Admin Sementara
Route::get('/setup-admin', function () {
    $user = \App\Models\User::where('name', 'like', '%bagas%')->orWhere('email', 'like', '%bagas%')->first();
    if ($user) {
        $user->role = 'admin';
        $user->save();
        return 'Berhasil mengubah role ' . $user->name . ' menjadi admin! Silakan akses halaman /dashboard sekarang.';
    }
    return 'User tidak ditemukan.';
});

require __DIR__.'/auth.php';
