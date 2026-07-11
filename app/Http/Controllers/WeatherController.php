<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $weather = null;

        if (request('country')) {

            $country = Country::find(request('country'));

            if ($country) {

                $response = Http::get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $country->latitude,
                        'longitude' => $country->longitude,
                        'current' => 'temperature_2m,wind_speed_10m'
                    ]
                );

                $weather = $response->json();
            }
        }

        return view('weather', compact(
            'countries',
            'weather'
        ));
    }
}