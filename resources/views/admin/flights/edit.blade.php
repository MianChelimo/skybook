
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flight | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

    <main class="max-w-3xl mx-auto p-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Edit Flight</h1>

            <a href="{{ route('admin.flights.index') }}" class="text-blue-600">
                Back to Flights
            </a>
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

        <form method="POST"
              action="{{ route('admin.flights.update', $flight) }}"
              class="bg-white p-6 rounded-xl shadow space-y-4">

            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Flight Number</label>
                <input type="text" name="flight_number"
                       value="{{ old('flight_number', $flight->flight_number) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Airline</label>
                <input type="text" name="airline"
                       value="{{ old('airline', $flight->airline) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Origin</label>
                <input type="text" name="origin"
                       value="{{ old('origin', $flight->origin) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Destination</label>
                <input type="text" name="destination"
                       value="{{ old('destination', $flight->destination) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Departure Time</label>
                <input type="datetime-local" name="departure_time"
                       value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Arrival Time</label>
                <input type="datetime-local" name="arrival_time"
                       value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}"
                       required class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Ticket Price (KES)</label>
                <input type="number" name="price"
                       value="{{ old('price', $flight->price) }}"
                       min="0" step="0.01" required
                       class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-1">Available Seats</label>
                <input type="number" name="available_seats"
                       value="{{ old('available_seats', $flight->available_seats) }}"
                       min="1" required class="w-full border rounded-lg p-3">
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                Update Flight
            </button>

        </form>
    </main>
</body>
</html>
