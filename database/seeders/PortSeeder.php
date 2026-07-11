<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [

            // =====================
            // INDONESIA
            // =====================

            [
                'country_code' => 'ID',
                'port_name' => 'Tanjung Priok',
                'port_code' => 'IDTPP',
                'city' => 'Jakarta',
                'latitude' => -6.1044,
                'longitude' => 106.8865,
                'status' => 'Normal',
                'description' => 'Largest seaport in Indonesia'
            ],

            [
                'country_code' => 'ID',
                'port_name' => 'Tanjung Perak',
                'port_code' => 'IDSUB',
                'city' => 'Surabaya',
                'latitude' => -7.2048,
                'longitude' => 112.7322,
                'status' => 'Normal',
                'description' => 'Major port in East Java'
            ],

            [
                'country_code' => 'ID',
                'port_name' => 'Belawan',
                'port_code' => 'IDBLW',
                'city' => 'Medan',
                'latitude' => 3.7833,
                'longitude' => 98.6833,
                'status' => 'Busy',
                'description' => 'Major port in North Sumatra'
            ],

            [
                'country_code' => 'ID',
                'port_name' => 'Makassar Port',
                'port_code' => 'IDMKS',
                'city' => 'Makassar',
                'latitude' => -5.1477,
                'longitude' => 119.4327,
                'status' => 'Normal',
                'description' => 'Main gateway for Eastern Indonesia'
            ],

            // =====================
            // SINGAPORE
            // =====================

            [
                'country_code' => 'SG',
                'port_name' => 'Port of Singapore',
                'port_code' => 'SGSIN',
                'city' => 'Singapore',
                'latitude' => 1.2644,
                'longitude' => 103.8400,
                'status' => 'Busy',
                'description' => 'World leading transshipment port'
            ],

            // =====================
            // MALAYSIA
            // =====================

            [
                'country_code' => 'MY',
                'port_name' => 'Port Klang',
                'port_code' => 'MYPKG',
                'city' => 'Klang',
                'latitude' => 3.0000,
                'longitude' => 101.4000,
                'status' => 'Normal',
                'description' => 'Largest port in Malaysia'
            ],

            [
                'country_code' => 'MY',
                'port_name' => 'Tanjung Pelepas',
                'port_code' => 'MYTPP',
                'city' => 'Johor',
                'latitude' => 1.3611,
                'longitude' => 103.5480,
                'status' => 'Busy',
                'description' => 'Major container port'
            ],

            // =====================
            // INDIA
            // =====================

            [
                'country_code' => 'IN',
                'port_name' => 'Mumbai Port',
                'port_code' => 'INBOM',
                'city' => 'Mumbai',
                'latitude' => 18.9498,
                'longitude' => 72.8406,
                'status' => 'Delayed',
                'description' => 'Major port in India'
            ],

            [
                'country_code' => 'IN',
                'port_name' => 'Chennai Port',
                'port_code' => 'INMAA',
                'city' => 'Chennai',
                'latitude' => 13.0827,
                'longitude' => 80.2707,
                'status' => 'Normal',
                'description' => 'Major container port'
            ],

            [
                'country_code' => 'IN',
                'port_name' => 'Kolkata Port',
                'port_code' => 'INCCU',
                'city' => 'Kolkata',
                'latitude' => 22.5726,
                'longitude' => 88.3639,
                'status' => 'Busy',
                'description' => 'Oldest operating port in India'
            ]

        ];

        // Hapus semua data lama
        Port::truncate();

        foreach ($ports as $port) {

            $country = Country::where(
                'country_code',
                $port['country_code']
            )->first();

            if (!$country) {
                continue;
            }

            Port::updateOrCreate(
                [
                    'port_code' => $port['port_code']
                ],
                [
                    'country_id' => $country->id,
                    'port_name' => $port['port_name'],
                    'port_code' => $port['port_code'],
                    'city' => $port['city'],
                    'latitude' => $port['latitude'],
                    'longitude' => $port['longitude'],
                    'status' => $port['status'],
                    'description' => $port['description']
                ]
            );
        }
    }
}