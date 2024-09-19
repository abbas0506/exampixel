<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    //
    public function create($paperId)
    {
        $paper = Paper::find($paperId);
        return view('collaborator.pdf.create', compact('paper'));
    }

    public function  generatePDF(Request $request)
    {


        // $latex = "";
        // Get LaTeX code from request or any other source
        // $latex = $request->input('latex');

        // // Generate PDF
        // $pdfContent = PDFHelper::generateFromLatex($latex);

        // // Return PDF as response
        // return response($pdfContent, 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename="latex.pdf"');



        // // $paper = Paper::find($paperId);

        // // // $pdf = PDF::loadView('collaborator.papers.pdf', compact('paper'))->setPaper('a4', 'portrait');
        // // // $pdf->set_option("isPhpEnabled", true);

        // // // $file = "Award.pdf";
        // // // return $pdf->stream($file);

        // // $html = view('collaborator.papers.pdf', compact('paper'))->render(); // Assuming you have a Blade template named 'sample'

        // $data = [
        //     'title' => 'Sample PDF Document - ITCODSTUFF.COM',
        //     'content' => 'This is just a sample PDF document generated using DomPDF in Laravel.'
        // ];

        // // Load HTML content
        // $html = view('collaborator.papers.pdf', compact('paper'))->render();

        // // Instantiate Dompdf
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml($html);

        // // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // // Render PDF (important step!)
        // $dompdf->render();
        // return $dompdf->stream('document.pdf');
    }
    public function store(Request $request, $paperId)
    {

        $pageOrientation = $request->page_orientation;
        $pageSize = $request->page_size;
        $rows = $request->rows;
        $cols = $request->cols;
        $paper = Paper::find($paperId);
        $fontSize = $request->font_size;
        $pdf = PDF::loadView('collaborator.pdf.preview', compact('paper', 'rows', 'cols', 'fontSize'))->setPaper($pageSize, $pageOrientation);
        $pdf->set_option("isPhpEnabled", true);
        $file = "paper.pdf";
        return $pdf->stream($file);


        // $orientation = $request->page_orientation;
        // $pageSize = $request->page_size;
        // $rows = $request->rows;
        // $columns = $request->cols;
        // $paper = paper::find($paperId);
        // $fontSize = $request->font_size;
        // $data = view('papers.latex3', compact('paper', 'orientation', 'pageSize', 'columns', 'fontSize'))->render();
        // if (Storage::disk('local')->exists('paper.tex')) {
        //     Storage::disk('local')->delete('paper.tex');
        // }
        // $file = Storage::disk('local')->put('paper.tex', $data);
        // try {
        //     $res = Http::attach('file', $data, 'paper.tex')
        //         ->post('http://16.171.40.228/latex-to-pdf');
        //     if ($res->failed()) {
        //         return $res->body();
        //     }
        //     $output = Storage::disk('local')->put('paper.pdf', $res->body());
        //     return response()->file(storage_path('app/paper.pdf'));
        // } catch (\Exception $e) {
        //     return $e->getMessage();
        // }
        // $pdf = PDF::loadView('user.papers.pdf.preview', compact('paper', 'rows', 'cols', 'fontSize'))->setPaper($pageSize, $pageOrientation);
        // $pdf->set_option("isPhpEnabled", true);
        // $file = "paper.pdf";
        // return $pdf->stream($file);
    }
}
