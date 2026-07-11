<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country', 'ID');

        $population = null;
        $gdp = null;
        $inflation = null;

        $currency = null;
        $temperature = null;

        try {

            $populationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/SP.POP.TOTL?format=json"
            );

            $population = $populationResponse->json()[1][0]['value'] ?? null;


            $gdpResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdp = $gdpResponse->json()[1][0]['value'] ?? null;


            $inflationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflation = $inflationResponse->json()[1][0]['value'] ?? null;

            // Currency API

$currencyResponse = Http::get(
    "https://open.er-api.com/v6/latest/USD"
);

$currencyData = $currencyResponse->json();

$currency = $currencyData['rates']['IDR'] ?? null;


// Weather API

if ($countryData = Country::where(
    'country_code',
    $selectedCountry
)->first()) {

    $weatherResponse = Http::get(
        'https://api.open-meteo.com/v1/forecast',
        [
            'latitude' => $countryData->latitude,
            'longitude' => $countryData->longitude,
            'current' => 'temperature_2m'
        ]
    );

    $weatherData = $weatherResponse->json();

    $temperature =
        $weatherData['current']['temperature_2m']
        ?? null;
}

        } catch (\Exception $e) {

        }

        $countryData = Country::where(
    'country_code',
    $selectedCountry
)->first();

$weatherRisk = 0;
$inflationRisk = 0;
$currencyRisk = 0;

if ($temperature) {

    if ($temperature < 20) {
        $weatherRisk = 10;
    } elseif ($temperature <= 30) {
        $weatherRisk = 20;
    } else {
        $weatherRisk = 30;
    }
}

if ($inflation) {

    if ($inflation < 3) {
        $inflationRisk = 10;
    } elseif ($inflation <= 7) {
        $inflationRisk = 20;
    } else {
        $inflationRisk = 30;
    }
}

if ($currency) {

    if ($currency < 15000) {
        $currencyRisk = 10;
    } elseif ($currency <= 16000) {
        $currencyRisk = 20;
    } else {
        $currencyRisk = 30;
    }
}

$riskScore =
    $weatherRisk +
    $inflationRisk +
    $currencyRisk;

$riskLevel = 'Low';

if ($riskScore >= 70) {
    $riskLevel = 'Critical';
}
elseif ($riskScore >= 50) {
    $riskLevel = 'High';
}
elseif ($riskScore >= 30) {
    $riskLevel = 'Medium';
}

$totalCountries = Country::count();

$highRiskCountries = Country::where('population', '>', 1000000000)->count();

$mediumRiskCountries = Country::whereBetween(
    'population',
    [100000000, 1000000000]
)->count();

$lowRiskCountries = Country::where('population', '<', 100000000)->count();


return view('dashboard', compact(
    'countries',
    'selectedCountry',
    'population',
    'gdp',
    'inflation',
    'currency',
    'temperature',
    'riskScore',
    'riskLevel',
    'countryData',
    'totalCountries',
    'highRiskCountries',
    'mediumRiskCountries',
    'lowRiskCountries'
));
    }
}