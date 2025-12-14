<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardUser extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Total buku yang tersedia di perpustakaan
        $totalBooks = Book::where('stok', '>', 0)->count();
        
        // Buku yang sedang dipinjam oleh user ini
        $myBorrowedBooks = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();
        
        // Total riwayat peminjaman user
        $totalHistory = Peminjaman::where('user_id', $userId)->count();
        
        // Cari jatuh tempo terdekat (sisa hari) - PERBAIKAN DI SINI
        $closestBorrowing = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali')
            ->orderBy('tanggal_kembali', 'asc')
            ->first();
        
        $closestDueDate = null;
        if ($closestBorrowing && $closestBorrowing->tanggal_kembali) {
            // Hitung sisa hari (tanggal kembali - hari ini)
            $dueDate = Carbon::parse($closestBorrowing->tanggal_kembali);
            $today = Carbon::now()->startOfDay();
            
            // diffInDays tanpa parameter false, lalu cek apakah sudah lewat
            if ($dueDate->greaterThanOrEqualTo($today)) {
                // Belum lewat, hitung sisa hari
                $closestDueDate = $today->diffInDays($dueDate);
            } else {
                // Sudah lewat, set 0 atau bisa set negatif jika mau
                $closestDueDate = 0;
            }
        }
        
        // Daftar buku yang sedang dipinjam user
        $myActiveBorrowings = Peminjaman::with('book')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();
        
        // Buku paling populer (Top 5)
        $popularBooks = Book::withCount('peminjaman')
            ->having('peminjaman_count', '>', 0)
            ->orderBy('peminjaman_count', 'desc')
            ->take(5)
            ->get();
        
        return view('users.dashboard.dashboardusers', compact(
            'totalBooks',
            'myBorrowedBooks',
            'closestDueDate',
            'totalHistory',
            'myActiveBorrowings',
            'popularBooks'
        ));
    }
}