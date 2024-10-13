<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookApprovableController extends Controller
{
    //
    public function index($bookId)
    {

        $books = Book::where('subject_id', Auth::user()->teacher->subject_id)->get();

        if ($bookId) {
            $activeBook = Book::findOrFail($bookId);
        } else {
            $activeBook = $books->first();
        }

        $activeChapter = $activeBook->chapters->first();
        return view('collaborator.approvables.index', compact('books', 'activeBook', 'activeChapter'));
    }
}
