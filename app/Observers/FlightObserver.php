<?php
namespace App\Observers;

use App\Models\Flight;
use App\Models\FlightSeat;
use App\Models\FlightFare;
use Illuminate\Support\Facades\DB;

class FlightObserver
{
    public function created(Flight $flight): void
    {
        DB::transaction(function () use ($flight) 
        {
            
        // your seat generation here
        $letters = ['A', 'B', 'C', 'D', 'E'];

        for ($row = 1; $row <= 10; $row++) {

            if ($row === 1) {
                $travelClass = 'first_class';
            } elseif ($row <= 4) {
                $travelClass = 'business';
            } else {
                $travelClass = 'economy';
            }

            foreach ($letters as $letter) {
                FlightSeat::create([
                    'flight_id' => $flight->id,
                    'seat_number' => $row . $letter,
                    'travel_class' => $travelClass,
                    'is_available' => true,
                ]);
            }
        }

        // your fare generation here
        $basePrice = (float) $flight->price;

        $fares = [
            'economy' => $basePrice,
            'business' => $basePrice * 1.8,
            'first_class' => $basePrice * 2.5,
        ];

        foreach ($fares as $travelClass => $price) {
            FlightFare::create([
                'flight_id' => $flight->id,
                'travel_class' => $travelClass,
                'price' => $price,
            ]);
        }
        });
    }
}
