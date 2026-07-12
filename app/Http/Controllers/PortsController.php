<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortsController extends Controller
{
public function index()
{
    $countries = Country::orderBy('country_name')->get();

    $selectedCountry = request('country');

    $portsQuery = Port::with('country');

    if ($selectedCountry) {

        $portsQuery->whereHas('country', function ($query) use ($selectedCountry) {

            $query->where('country_code', $selectedCountry);

        });
    }

    $ports = $portsQuery
        ->orderBy('port_name')
        ->get();

    $mapPorts = $ports
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->values();

    $totalPorts = $ports->count();

    $normalPorts = $ports->where('status', 'Normal')->count();

    $busyPorts = $ports->where('status', 'Busy')->count();

    $delayedPorts = $ports->where('status', 'Delayed')->count();

    $closedPorts = $ports->where('status', 'Closed')->count();

    return view('ports.index', compact(
        'ports',
        'countries',
        'selectedCountry',
        'mapPorts',
        'totalPorts',
        'normalPorts',
        'busyPorts',
        'delayedPorts',
        'closedPorts'
    ));
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

        $ports->whereHas('country', function ($query) use ($selectedCountry) {

            $query->where(
                'country_code',
                $selectedCountry
            );

        });

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
