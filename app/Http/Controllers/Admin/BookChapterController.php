<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

class BookChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($bookId)
    {
        //
        $grades = Grade::all();
        $book = Book::findOrFail($bookId);
        $tagIds = $book->chapters->sortBy('tag_id')->pluck('tag_id')->unique();
        $tags = Tag::whereIn('id', $tagIds)->get();

        return view('admin.qbank.chapters.index', compact('grades', 'book', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bookId)
    {
        //
        $tags = Tag::all();
        $book = Book::findOrFail($bookId);
        return view('admin.qbank.chapters.create', compact('book', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bookId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
            'tag_id' => 'required|numeric',
        ]);

        $request->merge(['book_id' => $bookId]);
        $book = Book::findOrFail($bookId);
        try {
            // if no chapter exists against this serial, create new
            // if ($book->chapters()->where('sr', $request->sr)->count() == 0) {
            Chapter::create($request->all());
            return redirect()->route('admin.qbank-books.chapters.index', $book)->with('success', 'Successfully added');;
            // } else {
            // return redirect()->back()->with(['warning' => 'Chapter already exists']);
            // }
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
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
    public function edit($bookId, string $id)
    {
        //
        $book = Book::findOrFail($bookId);
        $chapter = Chapter::findOrFail($id);
        $tags = Tag::all();
        return view('admin.qbank.chapters.edit', compact('book', 'chapter', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $bookId, $chapterId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
            'tag_id' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($chapterId);

        try {
            $chapter->update($request->all());
            return redirect()->route('admin.qbank-books.chapters.index', $chapter->book_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId, string $id)
    {
        //
        $chapter = Chapter::findOrFail($id);
        try {
            $chapter->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
