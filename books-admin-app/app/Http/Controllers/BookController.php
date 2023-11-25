<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        // $books = Book::all();
        $books = Book::paginate(8);

        return view('book.index', ['books' => $books]);
    }
}
