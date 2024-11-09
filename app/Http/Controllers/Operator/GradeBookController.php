<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Grade;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class GradeBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $grades = Grade::all();
        $grade = Grade::findOrFail($id);
        return view('operator.books.index', compact('grades', 'grade'));
    }
}
