
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

    <main class="max-w-7xl mx-auto p-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Manage Flights</h1>
                <p class="text-slate-500 mt-2">View and manage available flights.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="border px-4 py-2 rounded-lg">
                    Dashboard
                </a>

                <a href="{{ route('admin.flights.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    + Add Flight
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-x-auto">

            <table class="w-full text-left">
                <thead class="bg-slate-800 text-white">
                    <tr>
                        <th class="p-4">Flight No.</th>
                        <th class="p-4">Airline</th>
                        <th class="p-4">Route</th>
                        <th class="p-4">Departure</th>
                        <th class="p-4">Arrival</th>
                        <th class="p-4">Price (KES)</th>
                        <th class="p-4">Seats</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($flights as $flight)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-4 font-semibold">
                                {{ $flight->flight_number }}
                            </td>

                            <td class="p-4">{{ $flight->airline }}</td>

                            <td class="p-4">
                                {{ $flight->origin }} → {{ $flight->destination }}
                            </td>

                            <td class="p-4">
                                {{ $flight->departure_time }}
                            </td>

                            <td class="p-4">
                                {{ $flight->arrival_time }}
                            </td>

                            <td class="p-4">
                                {{ number_format($flight->price, 2) }}
                            </td>

                            <td class="p-4">{{ $flight->available_seats }}</td>

                            <td class="p-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.flights.edit', $flight) }}"
                                       class="text-blue-600">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.flights.destroy', $flight) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this flight?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-slate-500">
                                No flights have been added yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-6">
            {{ $flights->links() }}
        </div>

    </main>
</body>
</html>
