
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Flight | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

    <main class="max-w-3xl mx-auto p-8">

        <div class="mb-6">
            <a href="{{ route('flights.search') }}" class="text-blue-600">
                ← Back to Flights
            </a>

            <h1 class="text-3xl font-bold text-slate-800 mt-4">
                Book Your Flight
            </h1>
            <p class="text-slate-500 mt-2">
                Confirm your flight details and select your passengers.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Flight Details</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-slate-500">Flight Number</p>
                    <p class="font-semibold">{{ $flight->flight_number }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Airline</p>
                    <p class="font-semibold">{{ $flight->airline }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">From</p>
                    <p class="font-semibold">{{ $flight->origin }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">To</p>
                    <p class="font-semibold">{{ $flight->destination }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Departure</p>
                    <p class="font-semibold">{{ $flight->departure_time }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Available Seats</p>
                    <p class="font-semibold">{{ $flight->available_seats }}</p>
                </div>
            </div>
        </div>

        <form method="POST"
              action="{{ route('bookings.store', $flight) }}"
              class="bg-white rounded-xl shadow p-6">

            @csrf

            <h2 class="text-xl font-bold mb-4">Passenger Selection</h2>

            <label for="passengers" class="block font-medium mb-2">
                Number of Passengers
            </label>

            <input
                type="number"
                id="passengers"
                name="passengers"
                min="1"
                max="{{ min(9, $flight->available_seats) }}"
                value="{{ old('passengers', 1) }}"
                required
                class="w-full border rounded-lg p-3"
            >

            <div class="mt-5 bg-blue-50 p-4 rounded-lg">
                <p class="text-slate-600">Price per passenger</p>
                <p class="font-semibold">
                    KES {{ number_format($flight->price, 2) }}
                </p>

                <p class="text-slate-600 mt-3">Estimated total</p>
                <p id="total-price" class="text-2xl font-bold text-blue-700">
                    KES {{ number_format($flight->price, 2) }}
                </p>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold p-3 rounded-lg mt-6">
                Confirm Booking
            </button>

        </form>

    </main>

    <script>
        const passengersInput = document.getElementById('passengers');
        const totalPrice = document.getElementById('total-price');
        const pricePerPassenger = {{ $flight->price }};

        function updateTotal() {
            const passengers = Number(passengersInput.value) || 0;
            const total = passengers * pricePerPassenger;

            totalPrice.textContent = 'KES ' + total.toLocaleString(
                'en-KE',
                { minimumFractionDigits: 2, maximumFractionDigits: 2 }
            );
        }

        passengersInput.addEventListener('input', updateTotal);
        updateTotal();
    </script>

</body>
</html>
