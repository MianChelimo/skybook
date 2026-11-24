<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\FlightSeat;

class BookingController extends Controller
{
    // Display the booking form
    public function create(Flight $flight)
    {

        // get seats that have not been booked
        $availableSeats=$flight->seats()
            ->where('is_available',true)
            ->OrderBy('seat_number')
            ->get();
         // get the fare for each class
            $fares=$flight->fares()
            ->get()
            ->keyBy('travel_class')
            ->map(function ($fare) {
                return $fare->price;
            });
            // Display the passenger details form

    // Make sure the flight can still be booked
    if ($flight->departure_time <= now() || $flight->available_seats <= 0) {
        return redirect()
            ->route('flights.search')
            ->with('error', 'This flight is no longer available for booking.');
    }

        return view('bookings.create', compact('flight', 'availableSeats', 'fares'));
    }

            // Save passenger details temporarily and proceed to seat selection
public function storePassengers(Request $request, Flight $flight)
{
    $validated = $request->validate([
        'passengers' => 'required|integer|min:1|max:9',

        'passengers_data' => 'required|array|min:1|max:9',

        'passengers_data.*.first_name' => 'required|string|max:100',

        'passengers_data.*.last_name' => 'required|string|max:100',

        'passengers_data.*.travel_class' => 'required|in:economy,business,first_class',
    ]);

    // Make sure the number of passenger records matches the selected count
    if (count($validated['passengers_data']) != $validated['passengers']) {
        throw ValidationException::withMessages([
            'passengers' => 'Please provide details for every passenger.',
        ]);
    }

    // Store passenger information in the session
    session([
        'skybook.booking.' . $flight->id . '.passengers' => $validated['passengers_data'],
    ]);

    return redirect()->route('bookings.seats', $flight);
    // Display the seat selection page
     
}   
    public function seats(Flight $flight)
    {
        // Retrieve passenger details from the session
        $passengers = session(
            'skybook.booking.' . $flight->id . '.passengers'
        );

        // Redirect if passenger details have not been entered
        if (!$passengers) {
            return redirect()
                ->route('bookings.create', $flight)
                ->with('error', 'Please enter passenger details first.');
        }

        // Retrieve all seats belonging to this flight
        $seats = $flight->seats()
            ->orderBy('seat_number')
            ->get();

        return view('bookings.seats', compact(
            'flight',
            'passengers',
            'seats'
        ));
    }

    // Save selected seats and proceed to booking summary
    public function storeSeats(Request $request, Flight $flight)
    {
        $passengers = session(
            'skybook.booking.' . $flight->id . '.passengers'
        );

        if (!$passengers) {
            return redirect()->route('bookings.create', $flight);
        }

        $validated = $request->validate([
            'passengers_data' => 'required|array',
            'passengers_data.*.flight_seat_id' => 'required|integer|distinct|exists:flight_seats,id',
        ]);

        if (count($validated['passengers_data']) !== count($passengers)) {
            throw ValidationException::withMessages([
                'passengers_data' => 'Please select a seat for every passenger.',
            ]);
        }

        foreach ($passengers as $index => $passenger) {

            $seatId = $validated['passengers_data'][$index]['flight_seat_id'] ?? null;

            $seat = FlightSeat::where('flight_id', $flight->id)
                ->find($seatId);

            if (
                !$seat ||
                !$seat->is_available ||
                $seat->travel_class !== $passenger['travel_class']
            ) {
                throw ValidationException::withMessages([
                    'passengers_data' => 'One or more selected seats are unavailable or do not match the travel class.',
                ]);
            }
        }

        session([
            'skybook.booking.' . $flight->id . '.seats' =>
                collect($validated['passengers_data'])
                    ->mapWithKeys(fn ($data, $index) => [
                        $index => $data['flight_seat_id']
                    ])
                    ->all()
        ]);

        return redirect()->route('bookings.summary', $flight);
    }

    // Display booking summary
public function summary(Flight $flight)
{
    $sessionKey = 'skybook.booking.' . $flight->id;

    $passengers = session($sessionKey . '.passengers');
    $selectedSeats = session($sessionKey . '.seats');

    if (!$passengers || !$selectedSeats) {
        return redirect()
            ->route('bookings.create', $flight)
            ->with('error', 'Please complete passenger and seat selection first.');
    }

    $summaryPassengers = [];
    $totalPrice = 0;

    foreach ($passengers as $index => $passenger) {

        $seatId = $selectedSeats[$index] ?? null;

        $seat = $flight->seats()
            ->where('id', $seatId)
            ->where('is_available', true)
            ->first();

        if (!$seat || $seat->travel_class !== $passenger['travel_class']) {
            return redirect()
                ->route('bookings.seats', $flight)
                ->with('error', 'One or more selected seats are no longer available.');
        }

        $fare = $flight->fares()
            ->where('travel_class', $passenger['travel_class'])
            ->first();

        if (!$fare) {
            abort(500, 'Fare information is missing for this travel class.');
        }

        $summaryPassengers[] = [
            'first_name' => $passenger['first_name'],
            'last_name' => $passenger['last_name'],
            'travel_class' => $passenger['travel_class'],
            'seat_number' => $seat->seat_number,
            'price' => $fare->price,
        ];

        $totalPrice += (float) $fare->price;
    }

    return view('bookings.summary', compact(
        'flight',
        'summaryPassengers',
        'totalPrice'
    ));
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
            ->with('success', 'Your booking has been created successfully!')
            ->with('error', ' please fill all the required fields and try again.');
    }

    // Display booking details
    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        return view('bookings.show', compact('booking'));
    }
}
