<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Country;

class ReportController extends Controller
{
    public function riskPdf()
    {
        $countries = Country::orderByDesc('population')
            ->take(20)
            ->get();

        $pdf = Pdf::loadView(
            'reports.risk-pdf',
            compact('countries')
        );

        return $pdf->download('risk-report.pdf');
    }
}