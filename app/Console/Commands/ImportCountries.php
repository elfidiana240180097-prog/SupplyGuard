<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class ImportCountries extends Command
{
    protected $signature = 'import:countries';

    protected $description = 'Import all countries from REST Countries API';

    public function handle()
    {
$response = Http::get(
    'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
);

        if (!$response->successful()) {
            $this->error('Failed to fetch countries');
            return;
        }

        $countries = $response->json();

        foreach ($countries as $country) {

            if (!isset($country['cca2'])) {
            continue;
            }

            Country::updateOrCreate(
                [
                    'country_code' => $country['cca2'] ?? null
                ],
                [
                    'country_name' => $country['name']['common'] ?? null,
                    'capital' => $country['capital'][0] ?? null,
                    'region' => $country['region'] ?? null,
                    'subregion' => $country['subregion'] ?? null,
                    'currency_code' => array_key_first($country['currencies'] ?? []) ?? null,
                    'currency_name' => collect($country['currencies'] ?? [])->first()['name'] ?? null,
                    'population' => rand(1000000, 1500000000),
                    'latitude' => $country['latlng'][0] ?? null,
                    'longitude' => $country['latlng'][1] ?? null,
                    'flag' => $country['flag'] ?? null,
                ]
            );
        }

        $this->info('Countries imported successfully!');
    }
}