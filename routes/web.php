<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// --- IMPORT DENGAN ALIAS (Solusi Error Nama Sama) ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
// ----------------------------------------------------

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\ServerController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\UpgradeController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\MissionController as UserMissionController;

// Halaman Depan (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- HAPUS ROUTE DEFAULT BREEZE DISINI AGAR TIDAK BENTROK ---
// (Route dashboard bawaan diganti dengan UserDashboard di bawah)

// Route Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// GROUP ROUTE ADMIN (Pakai Alias AdminDashboard)
// ==========================================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);

    // Route Manajemen Misi & Log Absensi
    Route::get('/missions', [MissionController::class, 'index'])->name('missions.index');
    Route::post('/missions/update', [MissionController::class, 'update'])->name('missions.update');
    Route::get('/missions/logs', [MissionController::class, 'logs'])->name('missions.logs');

    // Route Transaksi Keuangan
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');

    // Manajemen User
    Route::resource('users', UserController::class)->only(['index', 'show']);
    
    // Action Khusus User
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{user}/update-balance', [UserController::class, 'updateBalance'])->name('users.update-balance');

    // Laporan
    Route::get('/reports/referrals', [ReportController::class, 'referrals'])->name('reports.referrals');
    Route::get('/reports/servers', [ReportController::class, 'servers'])->name('reports.servers');

    // Kelola Iklan / Banners (HAPUS KATA 'admin.' di bagian name)
    Route::get('/banners', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [\App\Http\Controllers\Admin\BannerController::class, 'store'])->name('banners.store');
    Route::put('/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('banners.destroy');

    // Kelola Tentang Kami
    Route::get('/about', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
    Route::put('/about/update', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
    
});

// ==========================================
// GROUP ROUTE USER / MEMBER (Pakai Alias UserDashboard)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Member
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

    // --- ROUTE PROFILE SAYA ---
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');

    // --- ROUTE SERVER SAYA ---
    Route::get('/my-servers', [ServerController::class, 'index'])->name('user.servers');

    // --- ROUTE DOMPET ---
    Route::get('/wallet', [WalletController::class, 'index'])->name('user.wallet');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('user.wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('user.wallet.withdraw');

    // --- ROUTE CS / BANTUAN ---
    Route::get('/support', [SupportController::class, 'index'])->name('user.support');

    // --- ROUTE REFERRAL / UNDANG TEMAN ---
    Route::get('/referrals', [ReferralController::class, 'index'])->name('user.referrals');

    // --- ROUTE UPGRADE OWNER ---
    Route::get('/upgrade', [UpgradeController::class, 'index'])->name('user.upgrade');
    Route::post('/upgrade', [UpgradeController::class, 'store'])->name('user.upgrade.store');

    // --- MARKETPLACE SERVER ---
    Route::get('/products', [UserProductController::class, 'index'])->name('user.products.index');
    Route::post('/products/{product}/buy', [UserProductController::class, 'buy'])->name('user.products.buy');

    // --- ROUTE MISI HARIAN ---
    Route::get('/missions', [UserMissionController::class, 'index'])->name('user.missions.index');
    Route::post('/missions/{investment}/claim', [UserMissionController::class, 'claim'])->name('user.missions.claim');

    Route::post('/wallet/transfer', [\App\Http\Controllers\User\WalletController::class, 'transfer'])->name('user.wallet.transfer');
});

require __DIR__.'/auth.php';