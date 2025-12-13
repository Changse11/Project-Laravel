<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\BookController;

// ==================== ROUTE HOMEPAGE ====================
Route::get('/', function () {
    return view('welcome'); // atau redirect ke login
});

// ATAU jika mau langsung redirect ke login:
Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== ROUTE GUEST (Belum Login) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ==================== ROUTE ADMIN (Harus Login + Role Admin) ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Users
    Route::resource('users', UserController::class);
    
    // CRUD Books
    Route::resource('books', BookController::class);
});

// ==================== ROUTE USER (Harus Login + Role User) ====================
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    // Dashboard User
    Route::get('/dashboard', function() {
        return view('users.dashboard.dashboardusers');
    })->name('dashboard');
});

// ==================== LOGOUT (Semua User yang Login) ====================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');