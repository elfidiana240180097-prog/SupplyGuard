<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use App\Models\Country;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::with('country')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('watchlists.index', compact('watchlists'));
    }

    public function store($countryId)
    {
        Watchlist::firstOrCreate([
            'user_id' => auth()->id(),
            'country_id' => $countryId
        ]);

        return back()->with(
            'success',
            'Country added to watchlist.'
        );
    }

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id != auth()->id()) {
            abort(403);
        }

        $watchlist->delete();

        return back()->with(
            'success',
            'Country removed from watchlist.'
        );
    }
}