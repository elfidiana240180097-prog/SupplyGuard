<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private function getLatestValue($response)
    {
        $data = $response->json();

        if (!isset($data[1])) {
            return 0;
        }

        foreach ($data[1] as $row) {

            if (!is_null($row['value'])) {
                return $row['value'];
            }

        }

        return 0;
    }

    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country', 'ID');

        $population = 0;
        $gdp = 0;
        $inflation = 0;

        $currency = 0;
        $temperature = 0;

        $countryData = Country::where(
            'country_code',
            $selectedCountry
        )->first();

        try {

            /*
            |--------------------------------------------------------------------------
            | World Bank API
            |--------------------------------------------------------------------------
            */

            $populationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/SP.POP.TOTL?format=json"
            );

            $population = $this->getLatestValue(
                $populationResponse
            );

            $gdpResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdp = $this->getLatestValue(
                $gdpResponse
            );

            $inflationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflation = $this->getLatestValue(
                $inflationResponse
            );

            /*
            |--------------------------------------------------------------------------
            | Exchange Rate API
            |--------------------------------------------------------------------------
            */

            $currencyResponse = Http::get(
                "https://open.er-api.com/v6/latest/USD"
            );

            $currencyData = $currencyResponse->json();

            $currency = $currencyData['rates'][
                $countryData->currency_code ?? 'IDR'
            ] ?? 0;

            /*
            |--------------------------------------------------------------------------
            | Open Meteo API
            |--------------------------------------------------------------------------
            */

            if ($countryData) {

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
                    ?? 0;
            }

        } catch (\Exception $e) {

            $population = 0;
            $gdp = 0;
            $inflation = 0;
            $currency = 0;
            $temperature = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Risk Score
        |--------------------------------------------------------------------------
        */

        $riskData = RiskScore::where(
            'country_id',
            $countryData?->id
        )->first();

        $riskScore =
            $riskData->overall_score ?? 0;

        $riskLevel =
            $riskData->risk_level ?? 'Low';

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalCountries = Country::count();

        $highRiskCountries = RiskScore::whereIn(
            'risk_level',
            ['High', 'Critical']
        )->count();

        $mediumRiskCountries = RiskScore::where(
            'risk_level',
            'Medium'
        )->count();

        $lowRiskCountries = RiskScore::where(
            'risk_level',
            'Low'
        )->count();

        return view(
            'dashboard',
            compact(
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
            )
        );
    }
}