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
            | Population
            |--------------------------------------------------------------------------
            */

            $population = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/SP.POP.TOTL?format=json"
                )
            );

            /*
            |--------------------------------------------------------------------------
            | GDP
            |--------------------------------------------------------------------------
            */

            $gdp = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/NY.GDP.MKTP.CD?format=json"
                )
            );

            /*
            |--------------------------------------------------------------------------
            | Inflation
            |--------------------------------------------------------------------------
            */

            $inflation = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$selectedCountry}/indicator/FP.CPI.TOTL.ZG?format=json"
                )
            );

            /*
            |--------------------------------------------------------------------------
            | Currency
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
            | Weather
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

        /*
        |--------------------------------------------------------------------------
        | Top 5 Highest Risk Countries
        |--------------------------------------------------------------------------
        */

        $topRiskCountries = RiskScore::with('country')
            ->orderByDesc('overall_score')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Radar Chart
        |--------------------------------------------------------------------------
        */

        $riskComponents = [

            $riskData->weather_score ?? 0,
            $riskData->inflation_score ?? 0,
            $riskData->currency_score ?? 0,
            $riskData->news_score ?? 0,
            $riskData->port_score ?? 0

        ];

        /*
        |--------------------------------------------------------------------------
        | Pie Chart
        |--------------------------------------------------------------------------
        */

        $riskDistribution = [

            $lowRiskCountries,
            $mediumRiskCountries,
            $highRiskCountries

        ];

        /*
        |--------------------------------------------------------------------------
        | Map
        |--------------------------------------------------------------------------
        */

        $mapLat = $countryData->latitude ?? 0;

        $mapLng = $countryData->longitude ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Last Update
        |--------------------------------------------------------------------------
        */

        $lastUpdate = now()->format('d M Y H:i');

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
                'lowRiskCountries',
                'topRiskCountries',
                'riskComponents',
                'riskDistribution',
                'mapLat',
                'mapLng',
                'lastUpdate'
            )
        );
    }
}