<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FlightController extends Controller
{
    // Display all flights
    public function index()
    {
        $flights = Flight::latest()->paginate(10);

        return view('admin.flights.index', compact('flights'));
    }

    // Display the add flight form
    public function create()
    {
        return view('admin.flights.create');
    }

    // Save a new flight
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:255|unique:flights,flight_number',
            'airline' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        Flight::create($validated);
        Cache::forget('skybook:all_flights');

        return redirect()
            ->route('admin.flights.index')
            ->with('success', 'Flight added successfully!')
            ->with('error', 'Something went wrong, please try again.');
    }

    // Display one flight
    public function show(Flight $flight)
    {
        return view('admin.flights.show', compact('flight'));
    }

    // Display the edit form
    public function edit(Flight $flight)
    {
        return view('admin.flights.edit', compact('flight'));
    }

    // Update a flight
    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:255|unique:flights,flight_number,' . $flight->id,
            'airline' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        $flight->update($validated);
        Cache::forget('skybook:all_flights');


        return redirect()
            ->route('admin.flights.index')
            ->with('success', 'Flight updated successfully!')
            ->with('error', 'Something went wrong, please try again.');

    }

    // Delete a flight
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()
            ->route('admin.flights.index')
            ->with('success', 'Flight deleted successfully!');
    }
}
