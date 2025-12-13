<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard untuk ADMIN
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();

        // Return ke view admin
        return view('admin.dashboard.dashboard', compact('totalBooks', 'totalUsers'));
    }
}