<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AnswerKeyController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $testId)
    {
        //
        $test = Test::find($testId);
        return view('teacher.tests.anskey.show', compact('test'));
    }
    public function pdf(string $testId)
    {
        //
        $test = Test::find($testId);
        $pdf = PDF::loadView('teacher.tests.anskey.preview', compact('test'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "answerkey.pdf";
        return $pdf->stream($file);
    }
}
