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

    return response()->json([
        'message' => 'Risk API Ready'
    ]);

});

Route::get('/news', function () {

    return response()->json([
        'message' => 'News API Ready'
    ]);

});

Route::get('/currency', function () {

    return response()->json([
        'message' => 'Currency API Ready'
    ]);

});