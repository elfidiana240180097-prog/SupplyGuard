<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Port;
use App\Models\Article;
use App\Models\Country;
use App\Models\Watchlist;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'users' => User::count(),
            'ports' => Port::count(),
            'articles' => Article::count(),
            'countries' => Country::count(),
            'watchlists' => Watchlist::count(),
        ]);
    }
}