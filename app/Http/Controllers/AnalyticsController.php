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

        $selectedCountry = request('country', 'ID');

        $country = Country::where(
            'country_code',
            $selectedCountry
        )->first();

        $risk = RiskScore::where(
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

            $gdp = 0;
            $inflation = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Trend Data
        |--------------------------------------------------------------------------
        */

        $currencyTrend = [

            max(($risk->currency_score ?? 0) - 8, 0),
            max(($risk->currency_score ?? 0) - 6, 0),
            max(($risk->currency_score ?? 0) - 4, 0),
            max(($risk->currency_score ?? 0) - 2, 0),
            $risk->currency_score ?? 0

        ];

        $inflationTrend = [

            max($inflation - 2, 0),
            max($inflation - 1.5, 0),
            max($inflation - 1, 0),
            max($inflation - 0.5, 0),
            $inflation

        ];

        $gdpTrend = [

            $gdp * 0.85,
            $gdp * 0.90,
            $gdp * 0.95,
            $gdp * 0.98,
            $gdp

        ];

        $riskTrend = [

            max(($risk->overall_score ?? 0) - 20, 0),
            max(($risk->overall_score ?? 0) - 15, 0),
            max(($risk->overall_score ?? 0) - 10, 0),
            max(($risk->overall_score ?? 0) - 5, 0),
            $risk->overall_score ?? 0

        ];

        return view(
            'analytics',
            compact(
                'countries',
                'selectedCountry',
                'population',
                'gdp',
                'inflation',
                'risk',
                'currencyTrend',
                'inflationTrend',
                'gdpTrend',
                'riskTrend'
            )
        );
    }
}