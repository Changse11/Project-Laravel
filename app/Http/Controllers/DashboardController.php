<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Total jumlah buku (judul buku)
        $totalBooks = Book::count();
        
        // Total user/anggota (hanya role 'user', tidak termasuk admin)
        $totalUsers = User::where('role', 'user')->count();
        
        // Buku yang sedang dipinjam (status = 'dipinjam')
        $booksBorrowed = Peminjaman::where('status', 'dipinjam')->count();
        
        // Stok buku menipis (stok <= 5)
        $lowStock = Book::where('stok', '<=', 5)->count();
        
        // Aktivitas peminjaman terbaru (10 terakhir)
        $recentBorrowings = Peminjaman::with(['user', 'book'])
            ->latest()
            ->take(10)
            ->get();
        
        // Buku paling banyak dipinjam (Top 5)
        $popularBooks = Book::withCount('peminjaman')
            ->having('peminjaman_count', '>', 0)
            ->orderBy('peminjaman_count', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'booksBorrowed',
            'lowStock',
            'recentBorrowings',
            'popularBooks'
        ));
    }
}