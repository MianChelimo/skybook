
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

    <main class="max-w-2xl mx-auto p-8">

        <div class="bg-white rounded-xl shadow p-8">

            <div class="text-center mb-8">
                <div class="text-green-600 text-5xl mb-3">✓</div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Booking Created!
                </h1>

                <p class="text-slate-500 mt-2">
                    Your booking has been recorded successfully.
                </p>
            </div>

            @if (session('success'))
                <p class="bg-green-100 text-green-700 p-3 rounded-lg mb-5">
                    {{ session('success') }}
                </p>
            @endif

            <div class="border-t border-b py-5 space-y-4">

                <div class="flex justify-between">
                    <span class="text-slate-500">Booking Reference</span>
                    <strong>{{ $booking->booking_reference }}</strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Flight</span>
                    <strong>{{ $booking->flight->flight_number }}</strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Route</span>
                    <strong>
                        {{ $booking->flight->origin }} →
                        {{ $booking->flight->destination }}
                    </strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Passengers</span>
                    <strong>{{ $booking->passengers }}</strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Total Price</span>
                    <strong>
                        KES {{ number_format($booking->total_price, 2) }}
                    </strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Booking Status</span>
                    <strong>{{ ucfirst($booking->booking_status) }}</strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Payment Status</span>
                    <strong>{{ ucfirst($booking->payment_status) }}</strong>
                </div>

            </div>

            <a href="{{ route('dashboard') }}"
               class="block text-center bg-blue-600 text-white p-3 rounded-lg mt-6">
                Return to Dashboard
            </a>

        </div>

    </main>

</body>
</html>
