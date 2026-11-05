

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="hidden w-64 flex-col bg-blue-950 p-6 text-white md:flex">

            <h1 class="text-2xl font-bold tracking-wide">
                SkyBook
            </h1>

            <p class="mt-1 text-sm text-blue-200">
                Your journey begins here
            </p>

            <nav class="mt-12 space-y-3">

                <a href="{{ route('dashboard') }}"
                   class="block rounded-lg bg-blue-800 px-4 py-3 font-medium">
                    Dashboard
                </a>

                <a href="{{ route('flights.available') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-blue-900">
                    Search Flights
                </a>

                <a href="#bookings"
                   class="block rounded-lg px-4 py-3 hover:bg-blue-900">
                    My Bookings
                </a>

                <a href="#profile"
                   class="block rounded-lg px-4 py-3 hover:bg-blue-900">
                    My Profile
                </a>

            </nav>

            <div class="mt-auto border-t border-blue-800 pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-lg px-4 py-3 text-left text-blue-200 hover:bg-blue-900 hover:text-white">
                        Log Out
                    </button>
                </form>
            </div>

        </aside>


        <!-- Main Content -->
        <main class="min-w-0 flex-1 p-5 md:p-10">

            <!-- Welcome -->
            <div class="flex flex-wrap items-center justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Your personal travel space
                    </p>

                    <h2 class="mt-1 text-3xl font-bold text-gray-900">
                        Welcome, {{ auth()->user()->name }}!
                    </h2>

                    <p class="mt-2 text-gray-600">
                        Ready to plan your next journey?
                    </p>
                </div>

                <a href="{{ route('flights.available') }}"
                   class="rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                    + Book a Flight
                </a>

            </div>


            <!-- Statistics -->
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Bookings
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-blue-950">
                        {{ auth()->user()->bookings->count() }}
                    </h3>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Upcoming Trips
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-blue-950">
                                            {{ auth()->user()->bookings()
                        ->whereHas('flight', function ($query) {
                            $query->where('departure_time', '>', now());
                        })
                        ->where('booking_status', '!=', 'cancelled')
                        ->count() }}
                    </h3>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Completed Trips
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-blue-950">
                        0
                    </h3>
                </div>

            </div>


            <!-- Flight Search -->
            <section class="mt-10 rounded-xl bg-white p-6 shadow-sm">

                <h3 class="text-xl font-bold text-gray-900">
                    Where would you like to go?
                </h3>

                <p class="mt-2 text-gray-600">
                    Find available flights and plan your next adventure.
                </p>

                <a href="{{ route('flights.available') }}"
                   class="mt-5 inline-block rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                    Explore Available Flights
                </a>

            </section>


            
<!-- Recent Bookings -->
<section id="bookings" class="mt-10 rounded-xl bg-white p-6 shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold text-gray-900">
                Recent Bookings
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Your latest flight reservations.
            </p>
        </div>
    </div>

    @php
        $recentBookings = auth()->user()
            ->bookings()
            ->with('flight')
            ->latest()
            ->take(5)
            ->get();
    @endphp

    @forelse ($recentBookings as $booking)

        <div class="mt-5 rounded-lg border border-gray-200 p-5">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <div>
                    <p class="text-sm text-gray-500">
                        Booking Reference
                    </p>
                    <p class="font-bold text-blue-950">
                        {{ $booking->booking_reference }}
                    </p>
                </div>

                <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                    {{ ucfirst($booking->booking_status) }}
                </span>

            </div>

            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-sm text-gray-500">Flight</p>
                    <p class="font-semibold">
                        {{ $booking->flight->airline }}
                        ({{ $booking->flight->flight_number }})
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Route</p>
                    <p class="font-semibold">
                        {{ $booking->flight->origin }}
                        → {{ $booking->flight->destination }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Departure</p>
                    <p class="font-semibold">
                        {{ $booking->flight->departure_time->format('d M Y, H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Passengers</p>
                    <p class="font-semibold">
                        {{ $booking->passengers }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Total Price</p>
                    <p class="font-semibold">
                        KSh {{ number_format((float) $booking->total_price, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Payment</p>
                    <p class="font-semibold">
                        {{ ucfirst($booking->payment_status) }}
                    </p>
                </div>

            </div>

            <a href="{{ route('bookings.show', $booking) }}"
               class="mt-4 inline-block text-sm font-semibold text-blue-700 hover:underline">
                View Booking Details →
            </a>

        </div>

    @empty

        <div class="mt-6 rounded-lg border border-dashed border-gray-300 p-8 text-center">

            <p class="font-medium text-gray-700">
                No bookings yet
            </p>

            <p class="mt-2 text-sm text-gray-500">
                Your flight reservations will appear here once you book a flight.
            </p>

            <a href="{{ route('flights.available') }}"
               class="mt-4 inline-block rounded-lg bg-blue-900 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                Explore Flights
            </a>

        </div>

    @endforelse

</section>


            <!-- Profile -->
            <section id="profile" class="mt-10 rounded-xl bg-white p-6 shadow-sm">

                <h3 class="text-xl font-bold text-gray-900">
                    Account Information
                </h3>

                <div class="mt-5 space-y-3 text-sm">

                    <p>
                        <span class="font-semibold">Name:</span>
                        {{ auth()->user()->name }}
                    </p>

                    <p>
                        <span class="font-semibold">Email:</span>
                        {{ auth()->user()->email }}
                    </p>
                    <p>
                        Role: {{ ucfirst(auth()->user()->role) }}
                    </p>

                </div>

            </section>

        </main>

    </div>

</body>
</html>

