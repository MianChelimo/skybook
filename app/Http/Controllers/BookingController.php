<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Display the booking form
    public function create(Flight $flight)
    {
        return view('bookings.create', compact('flight'));
    }

    // Save a customer's booking
    public function store(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'passengers' => 'required|integer|min:1|max:9',
        ]);

        $booking = DB::transaction(function () use ($validated, $flight) {

            $flight = Flight::whereKey($flight->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($flight->departure_time <= now()) {
                throw ValidationException::withMessages([
                    'passengers' => 'This flight is no longer available for booking.',
                ]);
            }

            if ($validated['passengers'] > $flight->available_seats) {
                throw ValidationException::withMessages([
                    'passengers' => 'Not enough seats are available for this flight.',
                ]);
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'booking_reference' => 'SB-' . strtoupper(Str::random(8)),
                'passengers' => $validated['passengers'],
                'total_price' => $flight->price * $validated['passengers'],
                'booking_status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            $flight->decrement('available_seats', $validated['passengers']);

            return $booking;
        });

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Your booking has been created successfully!');
    }

    // Display booking details
    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        return view('bookings.show', compact('booking'));
    }
}
