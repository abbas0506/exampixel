<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Grade;
use Illuminate\Http\Request;

class PaperGradeBookChapterController extends Controller
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
        return view('collaborator.papers.create', compact('grades', 'grade', 'book'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
