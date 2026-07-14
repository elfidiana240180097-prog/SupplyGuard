<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
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

        $countryA = request('countryA', 'ID');
        $countryB = request('countryB', 'US');

        $dataA = Country::where(
            'country_code',
            $countryA
        )->first();

        $dataB = Country::where(
            'country_code',
            $countryB
        )->first();

        $gdpA = 0;
        $gdpB = 0;

        $inflationA = 0;
        $inflationB = 0;

        $temperatureA = 0;
        $temperatureB = 0;

        if ($dataA) {

            $gdpA = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$countryA}/indicator/NY.GDP.MKTP.CD?format=json"
                )
            );

            $inflationA = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$countryA}/indicator/FP.CPI.TOTL.ZG?format=json"
                )
            );

            $weatherA = Http::get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $dataA->latitude,
                    'longitude' => $dataA->longitude,
                    'current' => 'temperature_2m'
                ]
            )->json();

            $temperatureA =
                $weatherA['current']['temperature_2m']
                ?? 0;
        }

        if ($dataB) {

            $gdpB = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$countryB}/indicator/NY.GDP.MKTP.CD?format=json"
                )
            );

            $inflationB = $this->getLatestValue(
                Http::get(
                    "https://api.worldbank.org/v2/country/{$countryB}/indicator/FP.CPI.TOTL.ZG?format=json"
                )
            );

            $weatherB = Http::get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $dataB->latitude,
                    'longitude' => $dataB->longitude,
                    'current' => 'temperature_2m'
                ]
            )->json();

            $temperatureB =
                $weatherB['current']['temperature_2m']
                ?? 0;
        }

        $riskA =
            RiskScore::where(
                'country_id',
                $dataA?->id
            )->value('overall_score') ?? 0;

        $riskB =
            RiskScore::where(
                'country_id',
                $dataB?->id
            )->value('overall_score') ?? 0;

        return view(
            'comparison',
            compact(
                'countries',
                'countryA',
                'countryB',
                'dataA',
                'dataB',
                'gdpA',
                'gdpB',
                'inflationA',
                'inflationB',
                'temperatureA',
                'temperatureB',
                'riskA',
                'riskB'
            )
        );
    }
}