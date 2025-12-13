<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Hapus user
    public function destroy(User $user)
    {
        // Proteksi: Admin tidak bisa dihapus
        if ($user->role == 'admin') {
            return redirect()->route('users.index')
                ->with('error', 'Admin tidak bisa dihapus!');
        }

        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}