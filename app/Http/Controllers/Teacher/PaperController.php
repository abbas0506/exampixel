<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Event\Code\Test;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('teacher.papers.index', compact('grades', 'subjects'));
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

        $request->validate([
            'title' => 'required',
            'book_id' => 'required|numeric',
            'chapter_ids_array' => 'required',
        ]);

        $request->merge([
            'paper_date' => date('Y/m/d'),
            // 'exercise_only' => ($request->exercise_only) ? 1 : 0,
            // 'frequent_only' => ($request->frequent_only) ? 1 : 0,
            'user_id' => Auth::user()->id,
        ]);
        try {
            $paper = Paper::create($request->all());
            $chapterIdsArray = array();
            $chapterIdsArray = $request->chapter_ids_array;
            $chapters = Chapter::whereIn('id', $chapterIdsArray)->get();
            session([
                // 'testId' => $test->id,
                // 'chapters' => $chapters,
                'chapterIdsArray' => $chapterIdsArray,
            ]);
            return redirect()->route('teacher.papers.show', $paper);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $paper = Paper::find($id);
        return view('teacher.papers.show', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $book = Book::find($id);
        return view('teacher.papers.edit', compact('book'));
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
