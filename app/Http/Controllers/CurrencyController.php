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

        try {

            $response = Http::get(
                "https://open.er-api.com/v6/latest/USD"
            );

            $data = $response->json();

            $exchangeRate =
                $data['rates'][$country->currency_code] ?? 0;

        } catch (\Exception $e) {

            $exchangeRate = 0;

        }

        $currencyRisk = 'Low';

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
                'currencyRisk'
            )
        );
    }
}