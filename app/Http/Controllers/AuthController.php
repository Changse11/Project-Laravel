<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==================== LOGIN ====================

    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Cek credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            // if ($user->role === 'admin') {
            // return redirect()->route('admin.dashboard.dashboard')->with('success', 'Selamat datang Admin!');
            // } else {
            return redirect()->intended($user->role === 'admin' ? '/admin/dashboard' : '/')->with('success', 'Selamat datang!');
            // }
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    // ==================== REGISTER ====================

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Buat user baru dengan role 'user' otomatis
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // AUTO SET ROLE USER
        ]);

        // Auto login setelah register
        Auth::login($user);

        // Redirect ke dashboard user
        return redirect()->intended($user->role === 'admin' ? '/admin/dashboard' : '/')->with('success', 'Selamat datang!');
        // return redirect()->route('users.dashboard.dashboardusers')->with('success', 'Registrasi berhasil!');
    }

    // ==================== LOGOUT ====================

    // Logout
    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('success', 'Logout berhasil!');
        // return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
