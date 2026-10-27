
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Phone | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-slate-900">
            Verify your phone
        </h1>

        <p class="mt-2 text-sm text-slate-600">
            Enter the six-digit verification code to continue to SkyBook.
        </p>
        @if (app()->isLocal() && session('phone_otp_debug_code'))
    <div class="mt-4 rounded-lg bg-amber-50 p-3 text-sm text-amber-800">
        Development OTP:
        <strong>{{ session('phone_otp_debug_code') }}</strong>
    </div>
@endif

        @if ($errors->any())
            <div class="mt-4 rounded-lg bg-red-100 p-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('phone-otp.verify') }}" class="mt-6 space-y-4">
            @csrf

            <label for="code" class="block text-sm font-medium text-slate-700">
                Six-digit code
            </label>

            <input
                id="code"
                name="code"
                type="text"
                inputmode="numeric"
                autocomplete="one-time-code"
                pattern="[0-9]{6}"
                maxlength="6"
                required
                autofocus
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-center text-xl tracking-[0.4em] focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                placeholder="000000"
            >

            <button
                type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700"
            >
                Verify and continue
            </button>
        </form>

        <p class="mt-5 text-center text-xs text-slate-500">
            Your code expires after five minutes.
        </p>
    </main>
</body>
</html>
