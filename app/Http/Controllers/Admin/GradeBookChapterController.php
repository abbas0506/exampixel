<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Grade;
use App\Models\Tag;
use Illuminate\Http\Request;

class GradeBookChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($gradeId, $bookId)
    {
        //
        $grades = Grade::all();
        $grade = Grade::find($gradeId);
        if ($bookId)
            $book = Book::find($bookId);
        else
            $book = $grade->books->first();

        $tagIds = $book->chapters->sortBy('tag_id')->pluck('tag_id')->unique();
        $tags = Tag::whereIn('id', $tagIds)->get();

        return view('admin.chapters.index', compact('grades', 'grade', 'book', 'tags'));
    }
}
