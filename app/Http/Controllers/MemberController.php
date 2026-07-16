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
        ->get();

        return view(
            'member.news',
            compact('articles')
        );
    }

    public function weather()
    {
    return view('member.weather');
    }

    public function currency()
{
    $countries = Country::orderBy('country_name')->get();

    $country = Country::first();

    $exchangeRate = 0;

    return view(
        'member.currency',
        compact(
            'countries',
            'country',
            'exchangeRate'
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
    $countries = Country::orderBy('country_name')->get();

    return view(
        'member.countries',
        compact('countries')
    );
}

public function ports()
{
    $search = request('search');

    $ports = Port::with('country')

        ->when($search, function ($query) use ($search) {

            $query->where(
                'port_name',
                'like',
                "%{$search}%"
            );

        })

        ->get();

    $totalPorts = $ports->count();

    $normalPorts = $ports->where('status','Normal')->count();

    $busyPorts = $ports->where('status','Busy')->count();

    $delayedPorts = $ports->where('status','Delayed')->count();

    $mapPorts = $ports;

    return view(
        'member.ports',
        compact(
            'ports',
            'totalPorts',
            'normalPorts',
            'busyPorts',
            'delayedPorts',
            'mapPorts',
            'search'
        )
    );
}

}