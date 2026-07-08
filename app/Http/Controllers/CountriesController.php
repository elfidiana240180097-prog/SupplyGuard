<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('countries', compact('countries'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_code' => 'required|max:10|unique:countries,country_code',
            'country_name' => 'required|max:255',
            'capital' => 'required|max:255',
            'region' => 'required|max:255',
            'subregion' => 'nullable|max:255',
            'currency_code' => 'nullable|max:10',
            'currency_name' => 'nullable|max:255',
            'population' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'flag' => 'nullable|url'
        ]);

        Country::create($request->all());

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country successfully added.');
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'country_code' => 'required|max:10|unique:countries,country_code,' . $country->id,
            'country_name' => 'required|max:255',
            'capital' => 'required|max:255',
            'region' => 'required|max:255',
            'subregion' => 'nullable|max:255',
            'currency_code' => 'nullable|max:10',
            'currency_name' => 'nullable|max:255',
            'population' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'flag' => 'nullable|url'
        ]);

        $country->update($request->all());

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country successfully updated.');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country successfully deleted.');
    }
}