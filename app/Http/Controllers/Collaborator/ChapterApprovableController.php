<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterApprovableController extends Controller
{
    //
    public function index($chapterId)
    {
        $activeChapter = Chapter::findOrFail($chapterId);
        $activeBook = $activeChapter->book;
        $books = Book::where('subject_id', Auth::user()->teacher->subject_id)->get();


        return view('collaborator.approvables.index', compact('books', 'activeBook', 'activeChapter'));
    }
}
