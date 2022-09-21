<?php

namespace App\Http\Controllers;


class PDFController extends Controller
{
    
    public function pdf()
    {
        $myPdf = new HomeInstructionCovidPdf();
         $myPdf->Output('I', "HomeInstructionPdf.pdf", true);
            exit;   
    }

    
}
