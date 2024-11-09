<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\SubtypeMapping;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::all();
        $types = Type::all();
        if (session('bookId') && session('typeId'))
            $mappings = SubtypeMapping::where('book_id', session('bookId'))
                ->where('type_id', session('typeId'))
                ->get();
        else
            $mappings = SubtypeMapping::where('id', 0)->get();
        return view('admin.mapping.index', compact('books', 'types', 'mappings'));
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
            'book_id' => 'required',
            'type_id' => 'required|numeric',
        ]);

        try {
            session([
                'bookId' => $request->book_id,
                'typeId' => $request->type_id,
            ]);

            return redirect()->route('admin.mappings.index');
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
