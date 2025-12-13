<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\BookController;
use Illuminate\Support\Facades\Auth;

// ==================== ROUTE HOMEPAGE ====================
// Route::get('/', function () {
//     return view('welcome'); // atau redirect ke login
// });

// ATAU jika mau langsung redirect ke login:
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/', function () {
    if (Auth::user() == null) {
        return redirect('/login');
    }

    return Auth::user()->role === 'admin'
        ? redirect('/admin/dashboard')
        : redirect('/dashboard');
});

// ==================== ROUTE GUEST (Belum Login) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ==================== ROUTE ADMIN (Harus Login + Role Admin) ====================
Route::middleware(['auth', 'CheckAdmin'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Users
    Route::resource('users', UserController::class);

    // CRUD Books
    Route::resource('books', BookController::class);
});

// ==================== ROUTE USER (Harus Login + Role User) ====================
Route::middleware(['auth', 'CheckUser'])->group(function () {
    // Dashboard User
    Route::get('/dashboard', function () {
        return view('users.dashboard.dashboardusers');
    })->name('user.dashboard');
});

// ==================== LOGOUT (Semua User yang Login) ====================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
