<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->take(20)
            ->get();

        $weatherCountries = [];

        foreach ($countries as $country) {

            try {

                $response = Http::get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $country->latitude,
                        'longitude' => $country->longitude,
                        'current' => 'temperature_2m,wind_speed_10m'
                    ]
                );

                $weather = $response->json();

                $temperature =
                    $weather['current']['temperature_2m']
                    ?? 0;

                $wind =
                    $weather['current']['wind_speed_10m']
                    ?? 0;

                $risk = 'Normal';

                if ($wind > 40) {

                    $risk = 'High Wind';

                }

                if ($wind > 70) {

                    $risk = 'Storm Risk';

                }

                $weatherCountries[] = [

                    'country' => $country->country_name,

                    'lat' => $country->latitude,

                    'lng' => $country->longitude,

                    'temperature' => $temperature,

                    'wind' => $wind,

                    'risk' => $risk

                ];

            } catch (\Exception $e) {

            }

        }

        return view(
            'weather',
            compact(
                'weatherCountries'
            )
        );
    }
}