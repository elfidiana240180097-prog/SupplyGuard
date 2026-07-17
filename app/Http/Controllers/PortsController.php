<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortsController extends Controller
{
public function index()
{
    $countries = Country::whereHas('ports')
        ->orderBy('country_name')
        ->get();

    $selectedCountry = request('country');

    $search = request('search');

    $portsQuery = Port::with('country');

    if ($search) {

        $portsQuery->where(
            'port_name',
            'like',
            '%' . $search . '%'
        );
    }

    $selectedCountryName = null;

    if ($selectedCountry) {

        $country = Country::where(
            'country_code',
            $selectedCountry
        )->first();

        $selectedCountryName = $country?->country_name;

        $portsQuery->whereHas(
            'country',
            function ($query) use ($selectedCountry) {

                $query->where(
                    'country_code',
                    $selectedCountry
                );

            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Data untuk statistik & map
    |--------------------------------------------------------------------------
    */

    $allPorts = (clone $portsQuery)
        ->orderBy('port_name')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Data untuk tabel
    |--------------------------------------------------------------------------
    */

    $ports = $portsQuery
        ->orderBy('port_name')
        ->paginate(10);

    $mapPorts = $allPorts
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->values();

    $countryPortCount = $allPorts->count();

    $totalPorts = $allPorts->count();

    $normalPorts = $allPorts
        ->where('status', 'Normal')
        ->count();

    $busyPorts = $allPorts
        ->where('status', 'Busy')
        ->count();

    $delayedPorts = $allPorts
        ->where('status', 'Delayed')
        ->count();

    $closedPorts = $allPorts
        ->where('status', 'Closed')
        ->count();

    return view(
        'ports.index',
        compact(
            'ports',
            'countries',
            'selectedCountry',
            'selectedCountryName',
            'countryPortCount',
            'mapPorts',
            'totalPorts',
            'normalPorts',
            'busyPorts',
            'delayedPorts',
            'closedPorts'
        )
    );
}

    public function create()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('ports.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'country_id' => 'required|exists:countries,id',

            'port_name' => 'required|max:255',

            'port_code' => 'nullable|max:50',

            'city' => 'nullable|max:255',

            'latitude' => 'nullable|numeric',

            'longitude' => 'nullable|numeric',

            'status' => 'required',

            'description' => 'nullable'

        ]);

        Port::create($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success', 'Port successfully added.');
    }

    public function edit(Port $port)
    {
        $countries = Country::orderBy('country_name')->get();

        return view('ports.edit', compact('port', 'countries'));
    }

    public function update(Request $request, Port $port)
    {
        $request->validate([

            'country_id' => 'required|exists:countries,id',

            'port_name' => 'required|max:255',

            'port_code' => 'nullable|max:50',

            'city' => 'nullable|max:255',

            'latitude' => 'nullable|numeric',

            'longitude' => 'nullable|numeric',

            'status' => 'required',

            'description' => 'nullable'

        ]);

        $port->update($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success', 'Port successfully updated.');
    }

    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()
            ->route('ports.index')
            ->with('success', 'Port successfully deleted.');
    }

    public function map()
    {
        $countries = Country::orderBy('country_name')->get();

        $selectedCountry = request('country');

        $ports = Port::with('country');

        if ($selectedCountry) {

            $ports->whereHas(
                'country',
                function ($query) use ($selectedCountry) {

                    $query->where(
                        'country_code',
                        $selectedCountry
                    );

                }
            );
        }

        $ports = $ports->get();

        return view(
            'ports.map',
            compact(
                'ports',
                'countries',
                'selectedCountry'
            )
        );
    }
}