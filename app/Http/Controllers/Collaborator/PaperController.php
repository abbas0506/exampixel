<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $grades = Grade::all();

        return view('collaborator.papers.index', compact('grades'));
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
            'book_id' => 'required|numeric',
            'title' => 'required|max:255',
            'paper_date' => 'required|date',
            'chapter_ids_array' => 'required',
        ]);



        try {
            $user = Auth::user();
            $paper = $user->papers()->create([
                'book_id' => $request->book_id,
                'title' => $request->title,
                'paper_date' => $request->paper_date,
            ]);

            $chapterIdsArray = array();
            $chapterIdsArray = $request->chapter_ids_array;
            // $chapters = Chapter::whereIn('id', $chapterIdsArray)->get();
            session([
                'chapterIdsArray' => $chapterIdsArray,
            ]);
            return redirect()->route('collaborator.papers.show', $paper);
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
        $paper = Paper::findOrFail($id);
        $book = $paper->book;
        $types = Type::all();
        $selectedChapters = Chapter::whereIn('id', session('chapterIdsArray'))->get();
        return view('collaborator.papers.show', compact('paper', 'book', 'types', 'selectedChapters'));
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
