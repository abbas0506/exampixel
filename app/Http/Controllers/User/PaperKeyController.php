<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PaperKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id)
    {
        //
        $paper = Paper::findOrFail($id);
        return view('user.answer-keys.show', compact('paper'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pdf($id)
    {
        //
        $paper = Paper::findOrFail($id);
        $pdf = PDF::loadView('user.answer-keys.pdf', compact('paper'));
        $pdf->set_option("isPhpEnabled", true);
        $file = "key.pdf";
        return $pdf->stream($file);
    }
}
