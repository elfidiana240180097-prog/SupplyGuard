<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country', 'Indonesia');

        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q' => $selectedCountry,
                'lang' => 'en',
                'max' => 10,
                'apikey' => env('GNEWS_API_KEY')
            ]
        );

        $articles = $response->json()['articles'] ?? [];

        return view('news', compact(
            'articles',
            'countries',
            'selectedCountry'
        ));
    }
}