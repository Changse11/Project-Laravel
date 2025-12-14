<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    
    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}