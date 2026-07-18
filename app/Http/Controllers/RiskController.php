<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class RiskController extends Controller
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

        $countryModel = Country::where(
        'country_code',
        $selectedCountry
        )->first();

        $population = 0;
        $gdp = 0;
        $inflation = 0;

        try {

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

        } catch (\Exception $e) {

            $population = 0;
            $gdp = 0;
            $inflation = 0;

        }


                $currency = $countryModel->currency_code ?? '-';

        $temperature = 0;
        $windspeed = 0;
        $exchangeRate = 1;

        try {

        $weatherResponse = Http::get(
        'https://api.open-meteo.com/v1/forecast',
        [
            'latitude' => $countryModel->latitude,
            'longitude' => $countryModel->longitude,
            'current' => 'temperature_2m,wind_speed_10m'
        ]
    );

    $weather = $weatherResponse->json();

    $temperature =
        $weather['current']['temperature_2m']
        ?? 0;

    $windspeed =
        $weather['current']['wind_speed_10m']
        ?? 0;

} catch (\Exception $e) {

}
        

        /*
        |--------------------------------------------------------------------------
        | Weather Risk
        |--------------------------------------------------------------------------
        */

        $weatherRisk = 10;

if ($windspeed > 40) {
    $weatherRisk = 25;
}

if ($windspeed > 70) {
    $weatherRisk = 40;
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

        $currencyRisk = 10;

if ($exchangeRate > 100) {
    $currencyRisk = 20;
}

if ($exchangeRate > 1000) {
    $currencyRisk = 30;
}

        

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

        /*
|--------------------------------------------------------------------------
| News Risk From Sentiment
|--------------------------------------------------------------------------
*/

$positiveWords = PositiveWord::pluck('word')
    ->map(fn ($word) => strtolower($word))
    ->toArray();

$negativeWords = NegativeWord::pluck('word')
    ->map(fn ($word) => strtolower($word))
    ->toArray();

$articles = Article::where(
    'country_id',
    $countryModel?->id
)->latest()->take(20)->get();

$positiveScore = 0;
$negativeScore = 0;

foreach ($articles as $article) {

    $text =
        strtolower($article->title ?? '') .
        ' ' .
        strtolower($article->description ?? '');

    foreach ($positiveWords as $word) {

        if (str_contains($text, $word)) {

            $positiveScore++;

        }

    }

    foreach ($negativeWords as $word) {

        if (str_contains($text, $word)) {

            $negativeScore++;

        }

    }

}

$totalNewsScore =
    $positiveScore +
    $negativeScore;

$negativePercent = 0;

if ($totalNewsScore > 0) {

    $negativePercent =
        ($negativeScore / $totalNewsScore) * 100;

}

$newsRisk = 10;

if ($negativePercent >= 30) {

    $newsRisk = 30;

}

if ($negativePercent >= 60) {

    $newsRisk = 50;

}

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

        if ($countryModel) {

            RiskScore::updateOrCreate(

                [
                    'country_id' => $countryModel->id
                ],

                [
                    'weather_score' => $weatherRisk,
                    'inflation_score' => $inflationRisk,
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

        $rankingCountries = RiskScore::with('country')
        ->orderByDesc('overall_score')
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
                'currency',
                'temperature',
                'windspeed',
                'negativePercent',
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