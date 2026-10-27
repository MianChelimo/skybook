
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Results | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-blue-900 p-5 text-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <a href="/" class="text-2xl font-bold">SkyBook</a>
            <a href="/" class="rounded bg-white px-4 py-2 font-semibold text-blue-900">
                New Search
            </a>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-10">
        <h1 class="mb-2 text-3xl font-bold">Available Flights</h1>
        <p class="mb-8 text-gray-600">
            Here are the flights matching your search.
        </p>

        @if ($flights->isEmpty())
            <div class="rounded-lg bg-white p-8 shadow">
                <h2 class="text-xl font-semibold">No flights found</h2>
                <p class="mt-2 text-gray-600">
                    Try another route or departure date.
                </p>
                <a href="/" class="mt-4 inline-block rounded bg-blue-700 px-5 py-3 text-white">
                    Search Again
                </a>
            </div>
        @else
            <div class="space-y-5">
                @foreach ($flights as $flight)
                    <div class="rounded-xl bg-white p-6 shadow">
                        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-center">

                            <div>
                                <p class="text-sm text-gray-500">
                                    {{ $flight->airline }} · {{ $flight->flight_number }}
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-3">
                                    <div>
                                        <p class="text-xl font-bold">
                                            {{ $flight->departure_time->format('H:i') }}
                                        </p>
                                        <p>{{ $flight->origin }}</p>
                                    </div>

                                    <div class="text-gray-400">→</div>

                                    <div>
                                        <p class="text-xl font-bold">
                                            {{ $flight->arrival_time->format('H:i') }}
                                        </p>
                                        <p>{{ $flight->destination }}</p>
                                    </div>
                                </div>

                                <p class="mt-3 text-sm text-gray-500">
                                    Departure date:
                                    {{ $flight->departure_time->format('d M Y') }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $flight->available_seats }} seats available
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Price per passenger</p>
                                <p class="text-2xl font-bold text-blue-900">
                                    KSh {{ number_format((float) $flight->price, 2) }}
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>
