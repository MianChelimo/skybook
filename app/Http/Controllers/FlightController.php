<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'origin' => ['required', 'string', 'max:100'],
            'destination' => ['required', 'string', 'max:100'],
            'departure_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'passengers' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $flights = Flight::query()
            ->where('origin', 'like', '%' . $request->origin . '%')
            ->where('destination', 'like', '%' . $request->destination . '%')
            ->where('available_seats', '>=', $request->passengers)
            ->when($request->filled('departure_date'), function ($query) use ($request) {
                $query->whereDate(
                    'departure_time',
                    $request->departure_date
                );
            })
            ->orderBy('departure_time')
            ->get();

        return view('flights.results', compact('flights'));
    }

   public function available()
{
    $flights = Flight::hydrate(
        Cache::remember('skybook:available_flights', 300, function () {
            return Flight::query()
                ->where('available_seats', '>', 0)
                ->where('departure_time', '>', now())
                ->orderBy('departure_time')
                ->get()
                ->toArray();
        })
    );

    return view('flights.available', compact('flights'));

    }

}

