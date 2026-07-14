<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Carbon\Carbon;

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

    $country = Country::where(
    'country_name',
    $selectedCountry
)->first();

foreach ($articles as $article) {

    Article::updateOrCreate(

        [
            'url' => $article['url'] ?? ''
        ],

        [
            'country_id' => $country?->id,

            'title' =>
                $article['title'] ?? '',

            'source' =>
                $article['source']['name'] ?? '',

            'author' =>
                $article['source']['name'] ?? '',

            'description' =>
                $article['description'] ?? '',

            'content' =>
                $article['content'] ?? '',

            'image' =>
                $article['image'] ?? '',

            'published_at' =>
            isset($article['publishedAt'])
            ? Carbon::parse($article['publishedAt'])
            : now()
        ]
    );
}

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

    $totalScore =
    $positiveScore +
    $negativeScore;

if ($totalScore == 0) {

    $positivePercent = 0;
    $negativePercent = 0;
    $neutralPercent = 100;

} else {

    $positivePercent =
        round(
            ($positiveScore / $totalScore) * 100,
            2
        );

    $negativePercent =
        round(
            ($negativeScore / $totalScore) * 100,
            2
        );

    $neutralPercent =
        100 -
        $positivePercent -
        $negativePercent;
}

    if ($positiveScore > $negativeScore) {
        $sentiment = 'Positive';
    }

    if ($negativeScore > $positiveScore) {
        $sentiment = 'Negative';
    }

    $newsRiskScore = 10;

if ($negativePercent >= 30) {

    $newsRiskScore = 30;

}

if ($negativePercent >= 60) {

    $newsRiskScore = 50;

}

    return view('news', compact(
    'articles',
    'countries',
    'selectedCountry',
    'positiveScore',
    'negativeScore',
    'positivePercent',
    'negativePercent',
    'neutralPercent',
    'newsRiskScore',
    'sentiment'
));
}
}