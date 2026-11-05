
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyBook Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

    <header class="bg-slate-900 text-white px-8 py-5 flex justify-between items-center">
        <h1 class="text-2xl font-bold">SkyBook Admin</h1>
        <span>Administrator: {{ auth()->user()->name }}</span>
    </header>

    <main class="max-w-6xl mx-auto p-8">

        <h2 class="text-3xl font-bold text-slate-800 mb-2">
            Welcome, {{ auth()->user()->name }}!
        </h2>

        <p class="text-slate-600 mb-8">
            Manage flights, bookings and registered users from here.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-slate-700">Flight Management</h3>
                <p class="text-sm text-slate-500 my-3">Add and manage available flights.</p>
                <a href="{{ route('admin.flights.index') }}"
                   class="text-blue-600 font-semibold">
                    Manage Flights →
                </a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-slate-700">Bookings</h3>
                <p class="text-sm text-slate-500 my-3">View and manage customer bookings.</p>
                <span class="text-slate-400">Coming next</span>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-slate-700">Users</h3>
                <p class="text-sm text-slate-500 my-3">View registered SkyBook accounts.</p>
                <span class="text-slate-400">Coming next</span>
            </div>

        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button type="submit"
                    class="bg-red-600 text-white px-5 py-2 rounded-lg">
                Logout
            </button>
        </form>

    </main>
</body>
</html>
