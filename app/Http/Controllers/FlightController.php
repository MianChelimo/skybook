<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

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
}
