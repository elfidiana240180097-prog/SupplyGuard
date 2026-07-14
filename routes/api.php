<?php

use Illuminate\Support\Facades\Route;
use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;

Route::get('/countries', function () {

    return Country::orderBy('country_name')->get();

});

Route::get('/ports', function () {

    return Port::with('country')->get();

});

Route::get('/risk', function () {

    return RiskScore::with('country')
        ->orderByDesc('overall_score')
        ->get();

});

use App\Models\Article;

Route::get('/news', function () {

    return Article::latest()
        ->take(20)
        ->get();

});

Route::get('/currency', function () {

    return response()->json([
        'message' => 'Currency API Ready'
    ]);

});