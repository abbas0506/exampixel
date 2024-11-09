<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SimplePdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        // simple pdf
        $paper = Paper::findOrFail($id);
        return view('user.pdf.simple.create', compact('paper'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $paperId)
    {

        $request->validate([
            'orientation' => 'required',
            'page_size' => 'required',
            'rows' => 'required|numeric',
            'columns' => 'required|numeric',
            'font_size' => 'required',

        ]);

        $orientation = $request->orientation;
        $pageSize = $request->page_size;
        $rows = $request->rows;
        $columns = $request->columns;
        $fontSize = $request->font_size;

        $paper = Paper::findOrFail($paperId);

        $pdf = PDF::loadView('user.pdf.simple.preview', compact('paper', 'rows', 'columns', 'fontSize'))->setPaper($pageSize, $orientation);
        $pdf->set_option("isPhpEnabled", true);
        $file = "paper.pdf";
        return $pdf->stream($file);


        // $orientation = $request->orientation;
        // $pageSize = $request->page_size;
        // $rows = $request->rows;
        // $cols = $request->cols;
        // $paper = Paper::findOrFail($paperId);
        // $fontSize = $request->font_size;


    }

    /**
     * Display the specified resource.
     */
    public function show(string $testId, string $id) {}

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
