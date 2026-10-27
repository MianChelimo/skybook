
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <header class="bg-blue-900 px-6 py-4 text-white">
        <h1 class="text-2xl font-bold">SkyBook Dashboard</h1>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-12">
        <h2 class="text-3xl font-bold text-gray-900">
            Welcome to SkyBook!
        </h2>

        <p class="mt-3 text-gray-600">
            You are logged in successfully. Your next journey starts here.
        </p>

        <a href="{{ url('/') }}"
           class="mt-6 inline-block rounded-lg bg-blue-900 px-6 py-3 font-semibold text-white hover:bg-blue-800">
            Browse Flights
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                    class="rounded-lg border border-gray-300 px-6 py-3 text-gray-700 hover:bg-gray-200">
                Log Out
            </button>
        </form>
    </main>
</body>
</html>
