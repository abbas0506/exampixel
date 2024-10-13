<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Grade;
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
        $grade = Grade::findOrFail($gradeId);
        if ($bookId)
            $book = Book::findOrFail($bookId);
        else
            $book = $grade->books->first();
        return view('operator.chapters.index', compact('grades', 'grade', 'book'));
    }
}
