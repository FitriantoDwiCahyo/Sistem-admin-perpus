<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function topBook()
    {
        $books = Book::withCount('borrowed')
                ->orderBy('borrowed_count','desc')
                ->paginate(env('PAGINATION_ADMIN')); //withcount mengambil fungsi borrowed dri tabel borrow_history dari model book
        return view('admin.report.top-book',[
            'books' => $books
        ]);
    }

    public function topUser()
    {
        $users = User::withCount('borrow')
                 ->orderBy('borrow_count','desc')
                 ->paginate(env('PAGINATION_ADMIN'));


        return view('admin.report.top-user',[
            'users' => $users
        ]);
    }
}
