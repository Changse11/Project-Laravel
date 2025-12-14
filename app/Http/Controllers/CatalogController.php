<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('users.catalog.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('users.catalog.show', compact('book'));
    }
}