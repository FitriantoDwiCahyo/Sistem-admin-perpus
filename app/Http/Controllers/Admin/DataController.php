<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use App\Book;
use App\BorrowHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function authors()
    {
        $authors = Author::orderBy('id','ASC');

        return datatables()->of($authors)
                        ->addColumn('action','admin.author.action')
                        ->rawColumns(['action'])
                        ->toJson();
    }
    
    public function books()
    {
        $books = Book::orderBy('id','ASC')->get();

        $books->load('author'); //cara menghendle n+1

        return datatables()->of($books)
                        ->addColumn('author', function(Book $model){
                            return $model->author->name;
                        })
                        ->editColumn('cover', function(Book $model){
                            return '<img src="'. $model->getCover().'" height = "150px">';
                        })
                        ->addColumn('action','admin.book.action')
                        ->rawColumns(['cover','action'])
                        ->toJson();
    }

    public function borrows()
    {
        $borrows = BorrowHistory::isBorrowed()->latest()->get();

        $borrows->load('user','book');

        return datatables()->of($borrows)
                        ->addColumn('user', function(BorrowHistory $model){
                            return $model->user->name;
                        })
                        ->addColumn('book_title', function(BorrowHistory $model){
                            return $model->book->title;
                        })
                        ->addColumn('action','admin.borrow.action')
                        ->rawColumns(['action'])
                        ->toJson();
    }
}