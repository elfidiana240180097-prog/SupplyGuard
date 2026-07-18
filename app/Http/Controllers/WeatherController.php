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
            ->orderBy('country_name')
            ->limit(40)
            ->get();

        $weatherCountries = [];

        foreach ($countries as $country) {

            try {

                $response = Http::timeout(5)->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $country->latitude,
                        'longitude' => $country->longitude,
                        'current' => 'temperature_2m,wind_speed_10m,rain'
                    ]
                );

                if (!$response->successful()) {
                    continue;
                }

                $weather = $response->json();

                $temperature =
                    $weather['current']['temperature_2m']
                    ?? 0;

                $wind =
                    $weather['current']['wind_speed_10m']
                    ?? 0;

                $rain =
                    $weather['current']['rain']
                    ?? 0;

                $risk = 'Low';

                if ($wind >= 40 || $rain >= 10) {
                    $risk = 'Medium';
                }

                if ($wind >= 70 || $rain >= 30) {
                    $risk = 'High';
                }

                $weatherCountries[] = [

                    'country' => $country->country_name,
                    'country_code' => $country->country_code,

                    'lat' => $country->latitude,
                    'lng' => $country->longitude,

                    'temperature' => $temperature,
                    'wind' => $wind,
                    'rain' => $rain,

                    'risk' => $risk
                ];

            } catch (\Exception $e) {

                continue;
            }
        }

        return view(
            'weather',
            compact('weatherCountries')
        );
    }
}