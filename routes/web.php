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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER AREA
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics');

    Route::resource('countries', CountriesController::class);

    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather');

    Route::get('/currency', [CurrencyController::class, 'index'])
        ->name('currency');

    Route::get('/news', [NewsController::class, 'index'])
        ->name('news');

    Route::resource('ports', PortsController::class);

    Route::get('/ports-map', [PortsController::class, 'map'])
        ->name('ports.map');

    Route::get('/risk', [RiskController::class, 'index'])
        ->name('risk');

    Route::get('/comparison', [ComparisonController::class, 'index'])
        ->name('comparison');

    Route::get('/watchlists', [WatchlistController::class, 'index'])
        ->name('watchlists.index');

    Route::post('/watchlists/{countryId}', [WatchlistController::class, 'store'])
        ->name('watchlists.store');

    Route::delete('/watchlists/{watchlist}', [WatchlistController::class, 'destroy'])
        ->name('watchlists.destroy');

    Route::get('/risk-report-pdf', [ReportController::class, 'riskPdf'])
        ->name('risk.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])
->prefix('admin')
->group(function () {

    Route::get(
        '/dashboard',
        [AdminController::class, 'dashboard']
    )->name('admin.dashboard');

    Route::resource('users', UserController::class);

    Route::resource(
    'articles',
    ArticleController::class
    );


});

require __DIR__.'/auth.php';