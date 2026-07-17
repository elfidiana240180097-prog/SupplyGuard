<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Http;
use App\Models\Port;

class MemberController extends Controller
{
    public function dashboard()
    {
        $articles = Article::where(
            'status',
            'published'
        )
        ->latest()
        ->take(5)
        ->get();

        return view(
            'member.dashboard',
            compact('articles')
        );
    }

    public function news()
    {
        $articles = Article::where(
            'status',
            'published'
        )
        ->latest()
        ->paginate(6);

        return view(
            'member.news',
            compact('articles')
        );
    }

    public function weather()
{
    $search = request('search');

    $countries = Country::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->when($search, function ($query) use ($search) {

            $query->where(
                'country_name',
                'like',
                '%' . $search . '%'
            );

        })
        ->orderBy('country_name')
        ->take(30)
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
                $weather['current']['temperature_2m'] ?? 0;

            $wind =
                $weather['current']['wind_speed_10m'] ?? 0;

            $risk = 'Normal';

            if ($wind > 70) {

                $risk = 'Storm Risk';

            } elseif ($wind > 40) {

                $risk = 'High Wind';

            }

            $weatherCountries[] = [

                'country' => $country->country_name,

                'country_code' => $country->country_code,

                'flag' => $country->flag,

                'lat' => $country->latitude,

                'lng' => $country->longitude,

                'temperature' => $temperature,

                'wind' => $wind,

                'risk' => $risk

            ];

        } catch (\Exception $e) {

            continue;

        }
    }

    return view(
        'member.weather',
        compact(
            'weatherCountries',
            'search'
        )
    );
}

    public function currency()
{
    $countries = Country::orderBy('country_name')
        ->paginate(12);

    $rates = [];

    try {

        $response = Http::timeout(5)
            ->get('https://open.er-api.com/v6/latest/USD');

        $rates = $response->json()['rates'] ?? [];

    } catch (\Exception $e) {

        $rates = [];

    }

    return view(
        'member.currency',
        compact(
            'countries',
            'rates'
        )
    );
}

    public function watchlists()
{
    $watchlists = Watchlist::where(
        'user_id',
        auth()->id()
    )->get();

    return view(
        'member.watchlist',
        compact('watchlists')
    );
}

public function countries()
{
    $search = request('search');

    $countries = Country::when($search, function ($query) use ($search) {

        $query->where(
            'country_name',
            'like',
            "%{$search}%"
        );

    })
    ->orderBy('country_name')
    ->paginate(10);

    return view(
        'member.countries',
        compact(
            'countries',
            'search'
        )
    );
}

public function ports()
{
    $search = request('search');
    $selectedCountry = request('country');

    $countries = Country::whereHas('ports')
        ->orderBy('country_name')
        ->get();

    $portsQuery = Port::with('country');

    if ($search) {
        $portsQuery->where(
            'port_name',
            'like',
            '%' . $search . '%'
        );
    }

    if ($selectedCountry) {

        $portsQuery->whereHas(
            'country',
            function ($query) use ($selectedCountry) {

                $query->where(
                    'country_code',
                    $selectedCountry
                );

            }
        );
    }

    $ports = $portsQuery
        ->orderBy('port_name')
        ->paginate(10);

    $mapPorts = Port::with('country')
        ->when($search, function ($query) use ($search) {
            $query->where(
                'port_name',
                'like',
                '%' . $search . '%'
            );
        })
        ->when($selectedCountry, function ($query) use ($selectedCountry) {

            $query->whereHas(
                'country',
                function ($q) use ($selectedCountry) {

                    $q->where(
                        'country_code',
                        $selectedCountry
                    );

                }
            );

        })
        ->get();

    $totalPorts = $mapPorts->count();

    $normalPorts = $mapPorts
        ->where('status','Normal')
        ->count();

    $busyPorts = $mapPorts
        ->where('status','Busy')
        ->count();

    $delayedPorts = $mapPorts
        ->where('status','Delayed')
        ->count();

    return view(
        'member.ports',
        compact(
            'ports',
            'countries',
            'selectedCountry',
            'totalPorts',
            'normalPorts',
            'busyPorts',
            'delayedPorts',
            'mapPorts'
        )
    );
}

}