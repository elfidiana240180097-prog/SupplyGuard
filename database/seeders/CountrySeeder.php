<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {

        $countries = [

            [
                'country_code' => 'ID',
                'country_name' => 'Indonesia',
                'capital' => 'Jakarta',
                'region' => 'Asia',
                'subregion' => 'South-Eastern Asia',
                'currency_code' => 'IDR',
                'currency_name' => 'Indonesian Rupiah',
                'population' => 281000000,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'flag' => 'https://flagcdn.com/w320/id.png'
            ],

            [
                'country_code' => 'JP',
                'country_name' => 'Japan',
                'capital' => 'Tokyo',
                'region' => 'Asia',
                'subregion' => 'Eastern Asia',
                'currency_code' => 'JPY',
                'currency_name' => 'Japanese Yen',
                'population' => 123000000,
                'latitude' => 35.6762,
                'longitude' => 139.6503,
                'flag' => 'https://flagcdn.com/w320/jp.png'
            ],

            [
                'country_code' => 'SG',
                'country_name' => 'Singapore',
                'capital' => 'Singapore',
                'region' => 'Asia',
                'subregion' => 'South-Eastern Asia',
                'currency_code' => 'SGD',
                'currency_name' => 'Singapore Dollar',
                'population' => 6000000,
                'latitude' => 1.3521,
                'longitude' => 103.8198,
                'flag' => 'https://flagcdn.com/w320/sg.png'
            ],

            [
                'country_code' => 'MY',
                'country_name' => 'Malaysia',
                'capital' => 'Kuala Lumpur',
                'region' => 'Asia',
                'subregion' => 'South-Eastern Asia',
                'currency_code' => 'MYR',
                'currency_name' => 'Malaysian Ringgit',
                'population' => 35000000,
                'latitude' => 3.1390,
                'longitude' => 101.6869,
                'flag' => 'https://flagcdn.com/w320/my.png'
            ],

            [
                'country_code' => 'US',
                'country_name' => 'United States',
                'capital' => 'Washington D.C.',
                'region' => 'North America',
                'subregion' => 'Northern America',
                'currency_code' => 'USD',
                'currency_name' => 'US Dollar',
                'population' => 340000000,
                'latitude' => 38.9072,
                'longitude' => -77.0369,
                'flag' => 'https://flagcdn.com/w320/us.png'
            ]

        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}