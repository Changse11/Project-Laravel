<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardUser;

// ==================== ROUTE HOMEPAGE ====================
Route::get('/', function () {
    if (Auth::user() == null) {
        return redirect('/login');
    }

    return Auth::user()->role === 'admin'
        ? redirect('/admin/dashboard')
        : redirect('/dashboard');
});

// ==================== ROUTE GUEST (Belum Login) ====================
// ==================== ROUTE GUEST (Belum Login) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ==================== ROUTE ADMIN (Harus Login + Role Admin) ====================
Route::middleware(['auth', 'CheckAdmin'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Users
    Route::resource('users', UserController::class);

    // CRUD Books
    Route::resource('books', BookController::class);
    
    // Data Peminjaman (Admin)
    Route::get('/peminjaman', [PeminjamanController::class, 'dataPeminjaman'])->name('admin.peminjaman');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'adminKembalikan'])->name('admin.peminjaman.kembalikan');
});

// ==================== ROUTE USER (Harus Login + Role User) ====================
Route::middleware(['auth', 'CheckUser'])->group(function () {
    // Dashboard User - GANTI YANG INI
    Route::get('/dashboard', [DashboardUser::class, 'index'])->name('user.dashboard');
    
    // Katalog Buku (untuk lihat dan pinjam buku)
    Route::get('/catalog', [CatalogController::class, 'index'])->name('users.catalog.index');
    
    // Peminjaman Buku (buku yang SEDANG dipinjam)
    Route::get('/peminjaman', [PeminjamanController::class, 'peminjamanAktif'])->name('peminjaman.aktif');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    
    // Riwayat Peminjaman (semua buku yang pernah dipinjam)
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat.peminjaman');
});

// ==================== LOGOUT (Semua User yang Login) ====================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== PROFILE (Semua User yang Login) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
