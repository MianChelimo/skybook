
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<main class="max-w-5xl mx-auto p-6 md:p-8">

    <div class="mb-8">
        <a href="{{ route('bookings.create', $flight) }}"
           class="text-blue-600 hover:underline">
            ← Back to Passenger Details
        </a>

        <h1 class="text-3xl font-bold text-slate-800 mt-4">
            Select Your Seats
        </h1>

        <p class="text-slate-500 mt-2">
            Choose a seat for every passenger.
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

        <h2 class="text-xl font-bold mb-4">
            Flight Information
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div>
                <p class="text-sm text-slate-500">Flight</p>
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

        </div>

    </div>

    <form method="POST"
          action="{{ route('bookings.seats.store', $flight) }}"
          class="bg-white rounded-xl shadow p-6">

        @csrf

        <h2 class="text-xl font-bold mb-5">
            Passenger Seat Selection
        </h2>

        <!-- Passenger tabs -->
        <div class="flex flex-wrap gap-3 mb-6">

            @foreach ($passengers as $index => $passenger)

                    <button
                        type="button"
                        onclick="showPassenger({{ $index }})"
                        id="tab-{{ $index +1 }}"
                        class="passenger-tab px-4 py-3 rounded-lg border font-semibold">

                       <span>
                            {{ $passenger['first_name'] }}
                            {{ $passenger['last_name'] }}
                        </span>

                        <span
                            id="check-{{ $index }}"
                            class="ml-2 text-green-600 font-bold hidden">
                            ✓
                        </span>
                    </button>

                @endforeach

        </div>

        @foreach ($passengers as $index => $passenger)

            <div
                id="passenger-{{ $index + 1 }}"
                class="passenger-panel {{ $index === 0 ? '' : 'hidden' }}">

                <div class="bg-blue-50 rounded-lg p-4 mb-6">

                    <h3 class="font-bold text-lg">
                        {{ $passenger['first_name'] }}
                        {{ $passenger['last_name'] }}
                    </h3>

                    <p class="text-sm text-slate-600 mt-1">
                        Travel Class:
                        {{ ucfirst(str_replace('_', ' ', $passenger['travel_class'])) }}
                    </p>

                </div>

                <input
                    type="hidden"
                    name="passengers_data[{{ $index }}][flight_seat_id]"
                    class="selected-seat"
                    required
                >

                <h3 class="font-semibold text-center mb-4">
                    AIRCRAFT SEAT MAP
                </h3>

                <div class="flex flex-wrap justify-center gap-5 text-sm mb-6">

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-green-500 rounded"></span>
                        Available
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-red-500 rounded"></span>
                        Occupied
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-blue-600 rounded"></span>
                        Selected
                    </div>

                </div>

                <div class="max-w-md mx-auto border-2 border-slate-300 rounded-t-full rounded-b-3xl p-6">

                    <p class="text-center text-xs text-slate-400 mb-6">
                        FRONT OF AIRCRAFT
                    </p>

                   <div class="space-y-3">

    @foreach ($seats->where('travel_class', $passenger['travel_class'])->groupBy(function ($seat) {
        return (int) filter_var($seat->seat_number, FILTER_SANITIZE_NUMBER_INT);
    }) as $rowNumber => $rowSeats)

        <div class="flex items-center justify-center gap-3">

            <!-- Left side: A, B, C -->
            <div class="flex gap-2">

                @foreach (['A', 'B', 'C'] as $letter)

                    @php
                        $seat = $rowSeats->firstWhere('seat_number', $rowNumber . $letter);
                    @endphp

                    @if ($seat)
                        <button
                            type="button"
                            data-seat-id="{{ $seat->id }}"
                            data-seat-number="{{ $seat->seat_number }}"
                            class="seat-button w-11 h-11 rounded-lg text-sm font-bold
                            {{ $seat->is_available
                                ? 'bg-green-100 text-green-800 hover:bg-green-200'
                                : 'bg-red-100 text-red-700 cursor-not-allowed' }}"
                            {{ !$seat->is_available ? 'disabled' : '' }}>

                            {{ $seat->seat_number }}

                        </button>
                    @else
                        <div class="w-11 h-11"></div>
                    @endif

                @endforeach

            </div>

            <!-- Aisle -->
            <div class="w-12 text-center text-xs text-slate-400">
                AISLE
            </div>

            <!-- Right side: D, E -->
            <div class="flex gap-2">

                @foreach (['D', 'E'] as $letter)

                    @php
                        $seat = $rowSeats->firstWhere('seat_number', $rowNumber . $letter);
                    @endphp

                    @if ($seat)
                        <button
                            type="button"
                            data-seat-id="{{ $seat->id }}"
                            data-seat-number="{{ $seat->seat_number }}"
                            class="seat-button w-11 h-11 rounded-lg text-sm font-bold
                            {{ $seat->is_available
                                ? 'bg-green-100 text-green-800 hover:bg-green-200'
                                : 'bg-red-100 text-red-700 cursor-not-allowed' }}"
                            {{ !$seat->is_available ? 'disabled' : '' }}>

                            {{ $seat->seat_number }}

                        </button>
                    @else
                        <div class="w-11 h-11"></div>
                    @endif

                @endforeach

            </div>

        </div>

    @endforeach

</div>
                </div>

                <p class="selected-seat-label text-center text-blue-700 font-semibold mt-5">
                    No seat selected
                </p>

            </div>

        @endforeach

        <div class="flex justify-between mt-8">

            <a href="{{ route('bookings.create', $flight) }}"
               class="px-6 py-3 border rounded-lg hover:bg-slate-50">
                Back
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold">

                Continue to Summary

            </button>

        </div>

    </form>

</main>

<script>
    console.log('SkyBook seat selection script is running');
    let currentPassenger = 0;

    // Keep selected seats for all passengers
    const selectedSeats = {};

    function showPassenger(index) {

        currentPassenger = index;

        document.querySelectorAll('.passenger-panel').forEach(panel => {
            panel.classList.add('hidden');
        });

        document.querySelectorAll('.passenger-tab').forEach(tab => {
            tab.classList.remove('bg-blue-600', 'text-white');
        });

        const activePanel = document.getElementById('passenger-' + (index + 1));
        const activeTab = document.getElementById('tab-' + (index + 1));

        // Only access classList if the elements actually exist in the DOM
        if (activePanel) activePanel.classList.remove('hidden');
        if (activeTab) activeTab.classList.add('bg-blue-600', 'text-white');
    }

    

    // Set the initial active passenger
    showPassenger(0);

    // Handle seat selection
    document.querySelectorAll('.passenger-panel').forEach((panel, index) => {

        panel.querySelectorAll('.seat-button').forEach(button => {

            button.addEventListener('click', function () {
                alert('Seat clicked: ' + this.dataset.seatNumber);
                const seatId = Number(this.dataset.seatId);
                const seatNumber = this.dataset.seatNumber;

                // Prevent another passenger from selecting the same seat
                const alreadySelected = Object.entries(selectedSeats).some(
                    ([passengerIndex, selectedSeatId]) =>
                        Number(passengerIndex) !== index &&
                        selectedSeatId === seatId
                );

                if (alreadySelected) {
                    alert('This seat has already been selected by another passenger.');
                    return;
                }

                selectedSeats[index] = seatId;

                panel.querySelector('.selected-seat').value = seatId;

                panel.querySelector('.selected-seat-label').textContent =
                    'Selected seat: ' + seatNumber;
                    document.getElementById('check-' + index)
                        .classList.remove('hidden');


                // Update seat appearance on all passenger maps
                updateSeatMaps();

            });

        });

    });

    function updateSeatMaps() {

        document.querySelectorAll('.passenger-panel').forEach((panel, index) => {

            panel.querySelectorAll('.seat-button').forEach(button => {

                const seatId = Number(button.dataset.seatId);

                button.classList.remove(
                    'bg-blue-600',
                    'text-white',
                    'bg-green-100',
                    'text-green-800',
                    'bg-slate-300',
                    'text-slate-500'
                );

                if (selectedSeats[index] === seatId) {

                    button.classList.add('bg-blue-600', 'text-white');

                } else if (Object.entries(selectedSeats).some(
                    ([passengerIndex, selectedSeatId]) =>
                        Number(passengerIndex) !== index &&
                        selectedSeatId === seatId
                )) {

                    button.classList.add('bg-slate-300', 'text-slate-500');

                } else {

                    button.classList.add('bg-green-100', 'text-green-800');

                }

            });

        });

    }

</script>

</body>
</html>
