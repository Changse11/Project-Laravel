<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $kategoris = ['Pendidikan', 'Teknologi', 'Novel', 'Agama', 'Sejarah'];
        return view('admin.books.create', compact('kategoris'));
    }

    public function store(BookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $kategoris = ['Pendidikan', 'Teknologi', 'Novel', 'Agama', 'Sejarah'];
        return view('admin.books.edit', compact('book', 'kategoris'));
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}