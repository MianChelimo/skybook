
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-description">
                Log in to your SkyBook account to manage your journeys.
            </p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-red-100 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}"
                  class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="email" class="auth-label">
                        Email address
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="auth-input"
                    >
                </div>

                <div>
                    <label for="password" class="auth-label">
                        Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="auth-input"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        value="1"
                        class="rounded border-gray-300"
                    >
                    <label for="remember" class="text-sm text-gray-600">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="auth-button">
                    Log In
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">
                    Create an account
                </a>
            </p>

            <p class="mt-4 text-center">
                <a href="{{ url('/') }}" class="auth-link">
                    Back to SkyBook
                </a>
            </p>
        </div>
    </main>
</body>
</html>
