<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        Flight::create([
            'flight_number' => 'SB101',
            'airline' => 'SkyBook Airways',
            'origin' => 'Nairobi',
            'destination' => 'Mombasa',
            'departure_time' => '2026-11-10 08:00:00',
            'arrival_time' => '2026-11-10 09:15:00',
            'price' => 7200.00,
            'available_seats' => 45,
        ]);

        Flight::create([
            'flight_number' => 'SB102',
            'airline' => 'SkyBook Airways',
            'origin' => 'Nairobi',
            'destination' => 'Kisumu',
            'departure_time' => '2026-11-10 10:30:00',
            'arrival_time' => '2026-11-10 11:20:00',
            'price' => 4500.00,
            'available_seats' => 30,
        ]);

        Flight::create([
            'flight_number' => 'SB103',
            'airline' => 'SkyBook Airways',
            'origin' => 'Mombasa',
            'destination' => 'Nairobi',
            'departure_time' => '2026-11-11 14:00:00',
            'arrival_time' => '2026-11-11 15:15:00',
            'price' => 6200.00,
            'available_seats' => 25,
        ]);

        Flight::create([
            'flight_number' => 'SB1045',
            'airline' => 'SkyBook Airways',
            'origin' => 'Diani',
            'destination' => 'Nanyuki',
            'departure_time' => '2026-11-11 14:00:00',
            'arrival_time' => '2026-11-11 15:15:00',
            'price' => 8200.00,
            'available_seats' => 25,
        ]);
    }
}
