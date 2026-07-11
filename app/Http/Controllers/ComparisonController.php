<?php

namespace App\Http\Controllers;

use App\Models\Country;

class ComparisonController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $countryA = request('countryA', 'ID');
        $countryB = request('countryB', 'US');

        $dataA = Country::where('country_code', $countryA)->first();
        $dataB = Country::where('country_code', $countryB)->first();

        return view('comparison', compact(
            'countries',
            'countryA',
            'countryB',
            'dataA',
            'dataB'
        ));
    }
}