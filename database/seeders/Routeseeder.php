<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'MBA',
                'destination_city' => 'Mombasa',
                'route_type' => 'domestic',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'KIS',
                'destination_city' => 'Kisumu',
                'route_type' => 'domestic',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'EDL',
                'destination_city' => 'Eldoret',
                'route_type' => 'domestic',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'MYD',
                'destination_city' => 'Malindi',
                'route_type' => 'domestic',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'UKA',
                'destination_city' => 'Ukunda',
                'route_type' => 'domestic',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'EBB',
                'destination_city' => 'Entebbe',
                'route_type' => 'international',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'DAR',
                'destination_city' => 'Dar es Salaam',
                'route_type' => 'international',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'JNB',
                'destination_city' => 'Johannesburg',
                'route_type' => 'international',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'DXB',
                'destination_city' => 'Dubai',
                'route_type' => 'international',
            ],
            [
                'origin_code' => 'NBO',
                'origin_city' => 'Nairobi',
                'destination_code' => 'LHR',
                'destination_city' => 'London',
                'route_type' => 'international',
            ],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                [
                    'origin_code' => $route['origin_code'],
                    'destination_code' => $route['destination_code'],
                ],
                $route
            );
        }
    }
}