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
            return redirect()->intended($user->role === 'admin' ? '/admin/dashboard' : '/')->with('success', 'Selamat datang!');
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
    }

    // ==================== LUPA PASSWORD ====================

    // Tampilkan halaman forgot password (input email)
    public function showForgotPassword()
    {
        return view('auth.forgot');
    }

    // Proses cek email
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cek apakah email ada di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar dalam sistem!')->withInput();
        }

        // Jika email ada, redirect ke halaman reset password dengan email
        return redirect()->route('password.reset', ['email' => $request->email]);
    }

    // Tampilkan halaman reset password (input password baru)
    public function showResetPassword(Request $request)
    {
        $email = $request->query('email');
        
        // Validasi email ada di query string
        if (!$email) {
            return redirect()->route('login')->with('error', 'Email tidak valid!');
        }

        return view('auth.reset', compact('email'));
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru.');
    }

    // ==================== LOGOUT ====================

    // Logout
    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}