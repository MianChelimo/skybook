
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
      action="{{ route('bookings.passengers.store', $flight) }}"
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

            <p class="text-sm text-slate-500 mt-2">
                You can book for up to 9 passengers at a time.
            </p>
            <div id="passenger-details" class="mt-6 space-y-6"></div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold p-3 rounded-lg mt-6">
                Next:Select Seats
            </button>

        </form>

    </main>

    <script>
    const passengersInput = document.getElementById('passengers');
    const passengerDetails = document.getElementById('passenger-details');

    function generatePassengerForms() {
        const numberOfPassengers = Number(passengersInput.value) || 0;

        passengerDetails.innerHTML = '';

        for (let i = 1; i <= numberOfPassengers; i++) {

            const passengerForm = document.createElement('div');

            passengerForm.className = 'bg-slate-50 border rounded-xl p-5';

            passengerForm.innerHTML = `
                
    <h3 class="text-lg font-bold mb-4">
        Passenger ${i}
    </h3>

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="block mb-2 font-medium">
                First Name
            </label>

            <input
                type="text"
                name="passengers_data[${i}][first_name]"
                required
                class="w-full border rounded-lg p-3"
            >
        </div>

        <div>
            <label class="block mb-2 font-medium">
                Last Name
            </label>

            <input
                type="text"
                name="passengers_data[${i}][last_name]"
                required
                class="w-full border rounded-lg p-3"
            >
        </div>

        <div class="col-span-2">
            <label class="block mb-2 font-medium">
                Travel Class
            </label>

            <select
                name="passengers_data[${i}][travel_class]"
                class="w-full border rounded-lg p-3 travel-class"
                required
            >
                <option value="">Choose Travel Class</option>
                <option value="economy">Economy</option>
                <option value="business">Business Class</option>
                <option value="first_class">First Class</option>
            </select>
        </div>

    </div>    
`;

            passengerDetails.appendChild(passengerForm);
        }
    }

    passengersInput.addEventListener('input', generatePassengerForms);

    generatePassengerForms();
</script>

</body>
</html>
