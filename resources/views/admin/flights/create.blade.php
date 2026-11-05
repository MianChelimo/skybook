
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 p-6">

    <main class="mx-auto max-w-3xl rounded-xl bg-white p-8 shadow-sm">

        <h1 class="text-2xl font-bold text-gray-900">
            Add a New Flight
        </h1>

        <p class="mt-2 text-gray-600">
            Enter the flight details below.
        </p>

        <form method="POST" action="{{ route('admin.flights.store') }}"
              class="mt-8 space-y-5">

            @csrf

            <div>
                <label class="mb-2 block font-medium">Flight Number</label>
                <input type="text" name="flight_number"
                       placeholder="e.g. KQ100"
                       class="w-full rounded-lg border border-gray-300 p-3">
            </div>

            <div>
                <label class="mb-2 block font-medium">Airline</label>
                <input type="text" name="airline"
                       placeholder="e.g. Kenya Airways"
                       class="w-full rounded-lg border border-gray-300 p-3">
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block font-medium">Origin</label>
                    <input type="text" name="origin"
                           placeholder="e.g. Nairobi"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>

                <div>
                    <label class="mb-2 block font-medium">Destination</label>
                    <input type="text" name="destination"
                           placeholder="e.g. London"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block font-medium">Departure Date & Time</label>
                    <input type="datetime-local" name="departure_time"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>

                <div>
                    <label class="mb-2 block font-medium">Arrival Date & Time</label>
                    <input type="datetime-local" name="arrival_time"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block font-medium">Ticket Price</label>
                    <input type="number" name="price" min="0.01" step="0.01"
                           placeholder="e.g. 25000"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>

                <div>
                    <label class="mb-2 block font-medium">Available Seats</label>
                    <input type="number" name="available_seats" min="0"
                           placeholder="e.g. 150"
                           class="w-full rounded-lg border border-gray-300 p-3">
                </div>
            </div>

            <button type="submit"
                    class="w-full rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                Save Flight
            </button>

        </form>

    </main>

</body>
</html>
