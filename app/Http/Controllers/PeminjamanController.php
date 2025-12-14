<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // USER: Tampilkan halaman daftar buku (catalog) untuk pinjam
    public function index()
    {
        $books = Book::where('stok', '>', 0)->get();
        return view('catalog.index', compact('books'));
    }

    // USER: Proses peminjaman buku
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_kembali' => 'required|date|after:today'
        ]);

        // VALIDASI: Cek apakah user sudah meminjam buku ini dan belum dikembalikan
        $sudahPinjam = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya!');
        }

        $book = Book::findOrFail($request->book_id);

        // Cek stok buku
        if ($book->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia');
        }

        // Buat peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku
        $book->decrement('stok');

        return redirect()->back()->with('success', 'Buku berhasil dipinjam');
    }

    // USER: Tampilkan buku yang SEDANG dipinjam (belum dikembalikan)
    public function peminjamanAktif()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('users.peminjaman.index', compact('peminjaman'));
    }

    // USER: Proses pengembalian buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Update status jadi dikembalikan
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        // Tambah stok buku kembali
        $peminjaman->book->increment('stok');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

    // USER: Tampilkan SEMUA riwayat peminjaman (termasuk yang sudah dikembalikan)
    public function riwayat()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('users.riwayat.index', compact('peminjaman'));
    }

    // ADMIN: Lihat semua data peminjaman
    public function dataPeminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    // ADMIN: Proses pengembalian buku (dari admin)
    public function adminKembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Update status jadi dikembalikan
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        // Tambah stok buku kembali
        $peminjaman->book->increment('stok');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }
}