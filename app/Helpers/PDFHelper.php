<?php

namespace App\Helpers;

use TCPDF;

class PdfHelper
{
    public static function generateFromLatex($latex)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->AddPage();
        $pdf->writeHTML($latex);
        return $pdf->Output('latex.pdf', 'S');
    }
}
