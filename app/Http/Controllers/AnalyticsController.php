<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use Illuminate\Support\Facades\Http;

class AnalyticsController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry =
            request('country', 'ID');

        $country =
            Country::where(
                'country_code',
                $selectedCountry
            )->first();

        $risk =
            RiskScore::where(
                'country_id',
                $country?->id
            )->first();

        $population = $country?->population ?? 0;

        $gdp = 0;
        $inflation = 0;

        try {

            $gdpResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdpData = $gdpResponse->json();

            $gdp =
                $gdpData[1][0]['value']
                ?? 0;

            $inflationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflationData =
                $inflationResponse->json();

            $inflation =
                $inflationData[1][0]['value']
                ?? 0;

        } catch (\Exception $e) {

        }

        return view(
            'analytics',
            compact(
                'countries',
                'selectedCountry',
                'population',
                'gdp',
                'inflation',
                'risk'
            )
        );
    }
}