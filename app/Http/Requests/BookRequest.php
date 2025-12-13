<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // atau sesuaikan dengan policy kamu
    }

    public function rules(): array
    {
        $bookId = $this->route('book') ? $this->route('book')->id : null;
        
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|in:Pendidikan,Teknologi,Novel,Agama,Sejarah',
            'isbn' => 'required|string|unique:books,isbn,' . $bookId,
            'stok' => 'required|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi',
            'penulis.required' => 'Penulis wajib diisi',
            'penerbit.required' => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'tahun_terbit.min' => 'Tahun terbit minimal 1900',
            'tahun_terbit.max' => 'Tahun terbit maksimal tahun ini',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'isbn.required' => 'ISBN wajib diisi',
            'isbn.unique' => 'ISBN sudah terdaftar',
            'stok.required' => 'Stok wajib diisi',
            'stok.min' => 'Stok minimal 0'
        ];
    }
}