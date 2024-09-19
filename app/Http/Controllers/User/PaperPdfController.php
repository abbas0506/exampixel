<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaperPdfController extends Controller
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
        $paper = Paper::find($id);
        return view('user.pdf.create', compact('paper'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $paperId)
    {

        $orientation = $request->orientation;
        $pageSize = $request->page_size;
        $rows = $request->rows;
        $columns = $request->columns;
        $paper = Paper::find($paperId);
        $fontSize = $request->font_size;

        // $pdf = PDF::loadView('user.pdf.preview', compact('paper', 'rows', 'columns', 'fontSize'))->setPaper($pageSize, $orientation);
        // $pdf->set_option("isPhpEnabled", true);
        // $file = "paper.pdf";
        // return $pdf->stream($file, ['Attachment' => 0]);


        $orientation = $request->orientation;
        $pageSize = $request->page_size;
        $rows = $request->rows;
        $cols = $request->cols;
        $paper = Paper::find($paperId);
        $fontSize = $request->font_size;

        $data = view('user.pdf.latex4', compact('paper', 'orientation', 'pageSize', 'rows', 'cols', 'fontSize', 'paper'))->render();
        // store the latex file
        Storage::disk('local')->put('paper.tex', $data);
        try {
            $res =  Http::timeout(8)->attach('file', $data, 'paper.tex')
                ->post('http://16.171.40.228/latex-to-pdf');
            if ($res->failed() && auth()->user()->email === 'mazeemrehan@gmail.com') {
                return response()->file(storage_path('app/paper.tex'));
            }
            if ($res->failed()) {
                return $res->body();
            }
            Storage::disk('local')->delete('paper.pdf');
            $output = Storage::disk('local')->put('paper.pdf', $res->body());

            $user = Auth::user();
            $user->sales()->create([]);
            return response()->file(storage_path('app/paper.pdf'));
        } catch (\Exception $e) {
            if (auth()->user()->email === 'mazeemrehan@gmail.com') {
                return response()->file(storage_path('app/paper.tex'));
            }
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $testId, string $id)
    {
        $test = Paper::findOrFail($testId);
        if ($test->questions->count() == 0) {
            return redirect()->route('user.tests.show', $testId)->with('error', 'No questions found');
        }
        $orientation = 'portrait';
        $pageSize = 'legalpaper'; // 'a4paper';
        $columns = 2;
        $fontSize = 8;
        $data = view('papers.latex3', compact('test', 'orientation', 'pageSize', 'columns', 'fontSize'))->render();
        if (Storage::disk('local')->exists('test.tex')) {
            Storage::disk('local')->delete('test.tex');
        }
        $file = Storage::disk('local')->put('test.tex', $data);
        try {
            $res = Http::attach('file', $data, 'test.tex')
                ->post('http://16.171.40.228/latex-to-pdf');
            if ($res->failed()) {
                return $res->body();
            }
            $output = Storage::disk('local')->put('test.pdf', $res->body());
            return response()->file(storage_path('app/test.pdf'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
