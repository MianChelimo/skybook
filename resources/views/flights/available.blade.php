
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

    <nav class="bg-blue-950 p-5 text-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                SkyBook
            </a>

            <a href="{{ route('dashboard') }}"
               class="rounded-lg bg-white px-4 py-2 font-semibold text-blue-950">
                Dashboard
            </a>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-10">

        <h1 class="text-3xl font-bold text-gray-900">
            Available Flights
        </h1>

        <p class="mt-2 mb-8 text-gray-600">
            Choose from our available flights and book your next journey.
        </p>

        @if ($flights->isEmpty())

            <div class="rounded-xl bg-white p-10 text-center shadow-sm">
                <h2 class="text-xl font-semibold">
                    No available flights
                </h2>

                <p class="mt-2 text-gray-600">
                    There are currently no flights available for booking.
                    Please check again later.
                </p>
            </div>

        @else

            <div class="space-y-5">

                @foreach ($flights as $flight)

                    <div class="rounded-xl bg-white p-6 shadow-sm">

                        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">

                            <div class="flex-1">

                                <p class="text-sm font-medium text-gray-500">
                                    {{ $flight->airline }} · {{ $flight->flight_number }}
                                </p>

                                <div class="mt-4 flex flex-wrap items-center gap-6">

                                    <div>
                                        <p class="text-2xl font-bold">
                                            {{ $flight->departure_time->format('H:i') }}
                                        </p>
                                        <p class="text-gray-600">
                                            {{ $flight->origin }}
                                        </p>
                                    </div>

                                    <div class="text-2xl text-blue-700">
                                        →
                                    </div>

                                    <div>
                                        <p class="text-2xl font-bold">
                                            {{ $flight->arrival_time->format('H:i') }}
                                        </p>
                                        <p class="text-gray-600">
                                            {{ $flight->destination }}
                                        </p>
                                    </div>

                                </div>

                                <p class="mt-4 text-sm text-gray-500">
                                    Departure:
                                    {{ $flight->departure_time->format('d M Y') }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $flight->available_seats }} seats remaining
                                </p>

                            </div>

                            <div class="border-t pt-5 md:border-t-0 md:border-l md:pl-8 md:pt-0">

                                <p class="text-sm text-gray-500">
                                    Price per passenger
                                </p>

                                <p class="mt-1 text-2xl font-bold text-blue-950">
                                    KSh {{ number_format((float) $flight->price, 2) }}
                                </p>

                                <a href="{{ route('bookings.create', $flight) }}"
                                   class="mt-4 inline-block rounded-lg bg-blue-900 px-6 py-3 font-semibold text-white hover:bg-blue-800">
                                    Book Now
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </main>

</body>
</html>
