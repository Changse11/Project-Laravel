<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Cek apakah role user adalah admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('customer.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        return $next($request);
    }
}