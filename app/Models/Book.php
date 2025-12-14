<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'isbn',
        'stok'
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer'
    ];
    
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}