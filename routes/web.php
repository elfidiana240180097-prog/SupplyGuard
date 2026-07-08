<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortsController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\ComparisonController;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Semua halaman setelah login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('countries', CountriesController::class);

    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather');

    Route::get('/currency', [CurrencyController::class, 'index'])
        ->name('currency');

    Route::get('/news', [NewsController::class, 'index'])
        ->name('news');

    Route::resource('ports', PortsController::class);

    Route::get('/risk', [RiskController::class, 'index'])
        ->name('risk');

    Route::get('/comparison', [ComparisonController::class, 'index'])
        ->name('comparison');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';