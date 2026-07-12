<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class RiskController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country', 'ID');

        $population = 0;
        $gdp = 0;
        $inflation = 0;

        try {

            $populationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/SP.POP.TOTL?format=json"
            );

            $population =
                $populationResponse->json()[1][0]['value']
                ?? 0;

            $gdpResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdp =
                $gdpResponse->json()[1][0]['value']
                ?? 0;

            $inflationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflation =
                $inflationResponse->json()[1][0]['value']
                ?? 0;

        } catch (\Exception $e) {

        }

        $weatherRisk = rand(10, 30);

$inflationRisk = 10;

if ($inflation > 3) {
    $inflationRisk = 20;
}

if ($inflation > 7) {
    $inflationRisk = 30;
}

$currencyRisk = 20;

$newsRisk = rand(10, 30);

$riskScore =
    $weatherRisk +
    $inflationRisk +
    $currencyRisk +
    $newsRisk;

$riskLevel = 'Low';

if ($riskScore >= 80) {

    $riskLevel = 'Critical';

}
elseif ($riskScore >= 60) {

    $riskLevel = 'High';

}
elseif ($riskScore >= 40) {

    $riskLevel = 'Medium';

}

        $rankingCountries = Country::orderByDesc('population')
            ->take(10)
            ->get();

        return view('risk', compact(
    'countries',
    'selectedCountry',
    'population',
    'gdp',
    'inflation',
    'weatherRisk',
    'inflationRisk',
    'currencyRisk',
    'newsRisk',
    'riskScore',
    'riskLevel',
    'rankingCountries'
));
    }
}