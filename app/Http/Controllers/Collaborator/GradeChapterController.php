<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Grade;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $grade = Grade::findOrFail($id);

        // $tags = Tag::all();

        if (Auth::user()->profile->subject_id) {
            $book = Book::where('grade_id', $id)
                ->where('subject_id', Auth::user()->profile->subject_id)
                ->first();

            $chapters = $book->chapters;
            $uniqueTagIds = $book->chapters->pluck('tag_id')->unique();

            $tags = Tag::whereIn('id', $uniqueTagIds)->get();

            return view('collaborator.chapters.index', compact('book', 'tags'));
        } else {
            echo "Profile incomplete";
        }
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
