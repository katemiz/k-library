<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Pdf;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Auth middleware used to protect the middleware.
    }

    public function securePdf($id)
    {
        $pdf = Pdf::find($id);

        $pdffile = Storage::path($pdf->stored_as);

        if (file_exists($pdffile)) {
            //Ensuring that the file exist
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            return response()->download(
                $pdffile,
                'Test File',
                $headers,
                'inline'
            ); // Send the pdf file for the user to download
        } else {
            abort(404, 'File not found!');
        }
    }
}
