<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
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

            $population = 0;
            $gdp = 0;
            $inflation = 0;

        }

        /*
        |--------------------------------------------------------------------------
        | Weather Risk
        |--------------------------------------------------------------------------
        */

        $weatherRisk = 15;

        if ($population > 100000000) {

            $weatherRisk = 25;

        }

        /*
        |--------------------------------------------------------------------------
        | Inflation Risk
        |--------------------------------------------------------------------------
        */

        $inflationRisk = 10;

        if ($inflation > 3) {

            $inflationRisk = 20;

        }

        if ($inflation > 7) {

            $inflationRisk = 30;

        }

        /*
        |--------------------------------------------------------------------------
        | Currency Risk
        |--------------------------------------------------------------------------
        */

        $currencyRisk = 15;

        /*
        |--------------------------------------------------------------------------
        | Port Risk
        |--------------------------------------------------------------------------
        */

        $portCount = Port::whereHas(
            'country',
            function ($query) use ($selectedCountry) {

                $query->where(
                    'country_code',
                    $selectedCountry
                );

            }
        )->count();

        $portRisk = 10;

        if ($portCount <= 2) {

            $portRisk = 25;

        }

        /*
        |--------------------------------------------------------------------------
        | News Risk
        |--------------------------------------------------------------------------
        */

        $newsRisk = 20;

        /*
        |--------------------------------------------------------------------------
        | Total Risk Score
        |--------------------------------------------------------------------------
        */

        $riskScore =
            $weatherRisk +
            $inflationRisk +
            $currencyRisk +
            $newsRisk +
            $portRisk;

        $riskLevel = 'Low';

        if ($riskScore >= 80) {

            $riskLevel = 'Critical';

        } elseif ($riskScore >= 60) {

            $riskLevel = 'High';

        } elseif ($riskScore >= 40) {

            $riskLevel = 'Medium';

        }

        /*
        |--------------------------------------------------------------------------
        | Save To Database
        |--------------------------------------------------------------------------
        */

        $countryModel = Country::where(
            'country_code',
            $selectedCountry
        )->first();

        if ($countryModel) {

            RiskScore::updateOrCreate(

                [
                    'country_id' => $countryModel->id
                ],

                [
                    'weather_score' => $weatherRisk,
                    'currency_score' => $currencyRisk,
                    'news_score' => $newsRisk,
                    'port_score' => $portRisk,
                    'overall_score' => $riskScore,
                    'risk_level' => $riskLevel
                ]

            );

        }

        /*
        |--------------------------------------------------------------------------
        | Ranking
        |--------------------------------------------------------------------------
        */

        $rankingCountries = Country::orderByDesc('population')
            ->take(10)
            ->get();

        return view(
            'risk',
            compact(
                'countries',
                'selectedCountry',
                'population',
                'gdp',
                'inflation',
                'weatherRisk',
                'inflationRisk',
                'currencyRisk',
                'newsRisk',
                'portRisk',
                'portCount',
                'riskScore',
                'riskLevel',
                'rankingCountries'
            )
        );
    }
}