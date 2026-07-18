<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Article;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request(
            'country',
            'Indonesia'
        );

        $articles = [];

        $country = Country::where(
            'country_name',
            $selectedCountry
        )->first();

        try {

            $response = Http::timeout(20)->get(
                'https://gnews.io/api/v4/search',
                [
                    'q' => $selectedCountry . ' economy',
                    'lang' => 'en',
                    'max' => 10,
                    'apikey' => env('GNEWS_API_KEY')
                ]
            );

            if ($response->successful()) {

                $articles =
                    $response->json()['articles']
                    ?? [];

                foreach ($articles as $article) {

                    Article::updateOrCreate(

                        [
                            'url' => $article['url'] ?? ''
                        ],

                        [
                            'country_id' => $country?->id,

                            'title' =>
                                $article['title']
                                ?? '',

                            'source' =>
                                $article['source']['name']
                                ?? '',

                            'author' =>
                                $article['source']['name']
                                ?? '',

                            'description' =>
                                $article['description']
                                ?? '',

                            'content' =>
                                $article['content']
                                ?? '',

                            'image' =>
                                $article['image']
                                ?? '',

                            'published_at' =>
                                isset($article['publishedAt'])
                                ? Carbon::parse(
                                    $article['publishedAt']
                                )
                                : now()
                        ]
                    );
                }
            }

        } catch (\Exception $e) {

        }

        if (count($articles) == 0) {

            $articles = Article::whereHas(
                'country',
                function ($query) use ($selectedCountry) {

                    $query->where(
                        'country_name',
                        $selectedCountry
                    );
                }
            )
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($article) {

                return [
                    'title' => $article->title,
                    'description' => $article->description,
                    'image' => $article->image,
                    'url' => $article->url,
                    'source' => [
                        'name' => $article->source
                    ]
                ];
            })
            ->toArray();
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

        $totalScore =
            $positiveScore +
            $negativeScore;

        if ($totalScore == 0) {

            $positivePercent = 0;
            $negativePercent = 0;
            $neutralPercent = 100;

        } else {

            $positivePercent = round(
                ($positiveScore / $totalScore) * 100,
                2
            );

            $negativePercent = round(
                ($negativeScore / $totalScore) * 100,
                2
            );

            $neutralPercent =
                max(
                    0,
                    100 -
                    $positivePercent -
                    $negativePercent
                );
        }

        $sentiment = 'Neutral';

        if ($positiveScore > $negativeScore) {

            $sentiment = 'Positive';

        } elseif ($negativeScore > $positiveScore) {

            $sentiment = 'Negative';

        }

        $newsRiskScore = 10;

        if ($negativePercent >= 30) {

            $newsRiskScore = 30;

        }

        if ($negativePercent >= 60) {

            $newsRiskScore = 50;

        }

        return view(
            'news',
            compact(
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
            )
        );
    }
}