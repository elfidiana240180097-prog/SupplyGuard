<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class NewsController extends Controller
{
    public function index()
{
    $countries = Country::orderBy('country_name')->get();

    $selectedCountry = request('country', 'Indonesia');

    $response = Http::get(
        'https://gnews.io/api/v4/search',
        [
            'q' => $selectedCountry . ' economy OR trade OR logistics OR shipping',
            'lang' => 'en',
            'max' => 10,
            'apikey' => env('GNEWS_API_KEY')
        ]
    );

    $articles = $response->json()['articles'] ?? [];

$positiveWords = PositiveWord::pluck('word')
    ->map(fn($word) => strtolower($word))
    ->toArray();

$negativeWords = NegativeWord::pluck('word')
    ->map(fn($word) => strtolower($word))
    ->toArray();

    $positiveScore = 0;
    $negativeScore = 0;

    foreach ($articles as $article) {

        $text =
            strtolower($article['title'] ?? '') .
            ' ' .
            strtolower($article['description'] ?? '');

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

    $sentiment = 'Neutral';

    if ($positiveScore > $negativeScore) {
        $sentiment = 'Positive';
    }

    if ($negativeScore > $positiveScore) {
        $sentiment = 'Negative';
    }

    return view('news', compact(
        'articles',
        'countries',
        'selectedCountry',
        'positiveScore',
        'negativeScore',
        'sentiment'
    ));
}
}