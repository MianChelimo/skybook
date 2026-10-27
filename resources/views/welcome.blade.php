
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SkyBook | Explore the World</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <header class="bg-white shadow-sm">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            <a href="{{ url('/') }}"
               class="text-2xl font-extrabold text-blue-700">
                SkyBook<span class="text-orange-500">.</span>
            </a>

            <div class="flex items-center gap-5">

                <a href="{{ url('/') }}"
                   class="font-medium hover:text-blue-700">
                    Flights
                </a>

                <a href="{{ route('login') }}"
                   class="font-medium hover:text-blue-700">
                    Log In
                </a>

                <a href="{{ route('register') }}"
                   class="rounded-lg bg-blue-900 px-5 py-2 font-semibold text-white transition hover:bg-blue-800">
                    Sign Up
                </a>

            </div>
        </nav>
    </header>

    <!-- Hero section and flight search -->
    <main>
        <section class="bg-blue-950 text-white">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 py-20 md:grid-cols-2 md:py-28">

                <div>
                    <p class="mb-4 font-semibold uppercase tracking-[0.2em] text-orange-400">
                        Your journey starts here
                    </p>

                    <h1 class="text-4xl font-extrabold leading-tight md:text-6xl">
                        The world is waiting for you.
                    </h1>

                    <p class="mt-6 max-w-lg text-lg leading-8 text-blue-100">
                        Discover destinations, compare flights and plan
                        your next adventure with SkyBook.
                    </p>
                </div>

                <!-- Flight search form -->
                <div class="rounded-2xl bg-white p-6 text-slate-900 shadow-2xl md:p-8">

                    <h2 class="text-2xl font-bold">
                        Find your flight
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Where would you like to go?
                    </p>

                    <form action="{{ route('flights.search') }}"
                          method="GET"
                          class="mt-6 space-y-5">

                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>
                                <label for="origin"
                                       class="mb-2 block text-sm font-semibold">
                                    From
                                </label>

                                <input
                                    id="origin"
                                    name="origin"
                                    type="text"
                                    value="{{ request('origin') }}"
                                    placeholder="e.g. Nairobi"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label for="destination"
                                       class="mb-2 block text-sm font-semibold">
                                    To
                                </label>

                                <input
                                    id="destination"
                                    name="destination"
                                    type="text"
                                    value="{{ request('destination') }}"
                                    placeholder="e.g. Mombasa"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>
                                <label for="departure_date"
                                       class="mb-2 block text-sm font-semibold">
                                    Departure
                                </label>

                                <input
                                    id="departure_date"
                                    name="departure_date"
                                    type="date"
                                    value="{{ request('departure_date') }}"
                                    min="{{ now()->toDateString() }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label for="passengers"
                                       class="mb-2 block text-sm font-semibold">
                                    Passengers
                                </label>

                                <select
                                    id="passengers"
                                    name="passengers"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                                >
                                    <option value="1" @selected(request('passengers', '1') == '1')>
                                        1 passenger
                                    </option>
                                    <option value="2" @selected(request('passengers') == '2')>
                                        2 passengers
                                    </option>
                                    <option value="3" @selected(request('passengers') == '3')>
                                        3 passengers
                                    </option>
                                    <option value="4" @selected(request('passengers') == '4')>
                                        4 passengers
                                    </option>
                                    <option value="5" @selected(request('passengers') == '5')>
                                        5 passengers
                                    </option>
                                </select>
                            </div>

                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-orange-500 px-6 py-4 font-bold text-white transition hover:bg-orange-600"
                        >
                            Search Flights →
                        </button>

                    </form>
                </div>

            </div>
        </section>

        <!-- Features -->
        <section class="mx-auto max-w-7xl px-6 py-16">

            <h2 class="text-3xl font-bold">
                Why fly with SkyBook?
            </h2>

            <div class="mt-8 grid gap-6 md:grid-cols-3">

                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">✈️</div>

                    <h3 class="mt-4 text-lg font-bold">
                        Explore destinations
                    </h3>

                    <p class="mt-2 text-slate-600">
                        Discover flights to places around the world.
                    </p>
                </article>

                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">💳</div>

                    <h3 class="mt-4 text-lg font-bold">
                        Compare prices
                    </h3>

                    <p class="mt-2 text-slate-600">
                        Review flight options before choosing your journey.
                    </p>
                </article>

                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">🎫</div>

                    <h3 class="mt-4 text-lg font-bold">
                        Manage bookings
                    </h3>

                    <p class="mt-2 text-slate-600">
                        Keep your trip details and booking information together.
                    </p>
                </article>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 px-6 py-8 text-center text-sm text-slate-400">
        © {{ date('Y') }} SkyBook. Your journey starts here.
    </footer>

</body>
</html>


