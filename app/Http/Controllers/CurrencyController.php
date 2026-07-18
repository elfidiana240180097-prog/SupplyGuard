<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country', 'ID');

        $country = Country::where(
            'country_code',
            $selectedCountry
        )->first();

        $exchangeRate = 0;

        $currencyRisk = 'Low';

        $currencyTrend = [];

        try {

            $response = Http::timeout(15)->get(
                'https://open.er-api.com/v6/latest/USD'
            );

            $data = $response->json();

            $exchangeRate =
                $data['rates'][$country->currency_code]
                ?? 0;

            /*
            |--------------------------------------------------------------------------
            | Simulasi Trend Harian
            |--------------------------------------------------------------------------
            */

            $currencyTrend = [

                round($exchangeRate * 0.96, 2),
                round($exchangeRate * 0.97, 2),
                round($exchangeRate * 0.98, 2),
                round($exchangeRate * 0.99, 2),
                round($exchangeRate * 1.00, 2),
                round($exchangeRate * 1.01, 2),
                round($exchangeRate, 2),

            ];

        } catch (\Exception $e) {

            $exchangeRate = 0;

            $currencyTrend = [
                0,0,0,0,0,0,0
            ];
        }

        if ($exchangeRate > 100) {

            $currencyRisk = 'Medium';

        }

        if ($exchangeRate > 1000) {

            $currencyRisk = 'High';

        }

        return view(
            'currency',
            compact(
                'countries',
                'country',
                'exchangeRate',
                'currencyRisk',
                'currencyTrend'
            )
        );
    }
}