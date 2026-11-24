
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<main class="max-w-5xl mx-auto p-6 md:p-8">

    <div class="mb-8">
        <a href="{{ route('bookings.seats', $flight) }}"
           class="text-blue-600 hover:underline">
            ← Back to Seat Selection
        </a>

        <h1 class="text-3xl font-bold text-slate-800 mt-4">
            Booking Summary
        </h1>

        <p class="text-slate-500 mt-2">
            Review your flight and passenger details before proceeding.
        </p>
    </div>

    <!-- Flight Information -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-xl font-bold mb-5">Flight Information</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

            <div>
                <p class="text-sm text-slate-500">Flight</p>
                <p class="font-semibold">{{ $flight->flight_number }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Airline</p>
                <p class="font-semibold">{{ $flight->airline }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Departure</p>
                <p class="font-semibold">
                    {{ $flight->origin }}
                </p>
                <p class="text-sm text-slate-500">
                    {{ $flight->departure_time->format('d M Y, H:i') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Destination</p>
                <p class="font-semibold">
                    {{ $flight->destination }}
                </p>
                <p class="text-sm text-slate-500">
                    {{ $flight->arrival_time->format('d M Y, H:i') }}
                </p>
            </div>

        </div>

    </div>

    <!-- Passenger Details -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-xl font-bold mb-5">
            Passenger Details
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-100 text-slate-600 text-sm">
                    <tr>
                        <th class="p-3">Passenger</th>
                        <th class="p-3">Travel Class</th>
                        <th class="p-3">Seat</th>
                        <th class="p-3 text-right">Fare</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($summaryPassengers as $passenger)

                        <tr class="border-b">

                            <td class="p-3 font-semibold">
                                {{ $passenger['first_name'] }}
                                {{ $passenger['last_name'] }}
                            </td>

                            <td class="p-3">
                                {{ ucfirst(str_replace('_', ' ', $passenger['travel_class'])) }}
                            </td>

                            <td class="p-3 font-semibold">
                                {{ $passenger['seat_number'] }}
                            </td>

                            <td class="p-3 text-right font-semibold">
                                KES {{ number_format($passenger['price'], 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- Total -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold text-slate-700">
                Total Booking Cost
            </span>

            <span class="text-2xl font-bold text-blue-700">
                KES {{ number_format($totalPrice, 2) }}
            </span>
        </div>

        <p class="text-sm text-slate-500 mt-2">
            Total fare for {{ count($summaryPassengers) }} passenger(s).
        </p>

    </div>

    <!-- Payment Button -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">

        <a href="{{ route('bookings.seats', $flight) }}"
           class="px-6 py-3 border border-slate-500 rounded-lg text-center hover: bg-slate-600 text-black">

            Change Seats
        </a>

        <button
            type="button"
            disabled
            class="bg-slate-400 text-white px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
            Proceed to Payment
        </button>

    </div>

    <p class="text-center text-sm text-slate-500 mt-4">
        Payment integration will be activated in the next stage.
    </p>

</main>

</body>
</html>
