<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookAndTypeMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($bookId, $typeId)
    {
        //
        $mappings = SubtypeMapping::all();
        $books = Book::all();
        $types = Type::all();
        if (session('bookId') && session('typeId')) {
            return view('admin.mappings.index', compact('mappings', 'books', 'types', 'bookId', 'typeId'));
        } else {
            $bookId = '';
            $typeId = '';
            return view('admin.mapping.index', compact('mappings', 'books', 'types', 'bookId', 'typeId'));
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
