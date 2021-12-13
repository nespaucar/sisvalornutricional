<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use PDF;
use Illuminate\Support\Facades\Auth;
use App\Librerias\Libreria;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Documntación
    public function exportarPdfAlgo(Request $request)
    {
        $view = \View::make('alguna.vista')->with(compact('variable1', 'variable2'));
        $html_content = $view->render();      
 
        PDF::SetTitle("Nombre PDF");
        PDF::AddPage(); 

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        PDF::writeHTML($html_content, true, true, true, true, '');

        PDF::Output("Nombre PDF".'.pdf', 'I');
    }

    public function show(Request $request) {
        //
    }
}
