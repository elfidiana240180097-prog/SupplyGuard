<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| Countries API
|--------------------------------------------------------------------------
*/

Route::get('/countries', function () {

    return response()->json(
        Country::orderBy('country_name')->get()
    );

});

/*
|--------------------------------------------------------------------------
| Ports API
|--------------------------------------------------------------------------
*/

Route::get('/ports', function () {

    return response()->json(
        Port::with('country')->get()
    );

});

/*
|--------------------------------------------------------------------------
| Risk API
|--------------------------------------------------------------------------
*/

Route::get('/risk', function () {

    return response()->json(

        RiskScore::with('country')
            ->orderByDesc('overall_score')
            ->get()

    );

});

/*
|--------------------------------------------------------------------------
| News API
|--------------------------------------------------------------------------
*/

Route::get('/news', function () {

    return response()->json(

        Article::latest()
            ->take(20)
            ->get()

    );

});

/*
|--------------------------------------------------------------------------
| Currency API
|--------------------------------------------------------------------------
*/

Route::get('/currency', function () {

    try {

        $response = Http::timeout(15)
            ->get('https://open.er-api.com/v6/latest/USD');

        return response()->json([
            'status' => 'success',
            'timestamp' => now(),
            'data' => $response->json()
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => 'Currency API unavailable'
        ], 500);

    }

});