<?php

namespace App\Http\Controllers\Frontend;

use App\Book;
use App\BorrowHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return view('frontend.book.index',[
            'title' => 'Beranda-Sistemperpus',
            'books' => $books
        ]);
    }
    
    public function show(Book $book)
    {
        return view('frontend.book.show',[
            'title' => $book->title,
            'book' => $book
        ]);
    }

    public function borrow(Book $book)
    {
       $user = auth()->user();

        if ($user->borrow()->isStillBorrowed($book->id)) {
            return redirect()->back()->with('toast','Kamu sudah meminjam buku dengan judul : '. $book->title);
        }

       $user->borrow()->attach($book);
       $book->decrement('qty'); //untuk mengurangi jumlah
        return redirect()->back()->with('toast','Berhasil meminjam buku');
    }
}
