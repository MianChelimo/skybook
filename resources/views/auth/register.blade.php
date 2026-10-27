
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | SkyBook</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <main class="auth-container">
        <div class="auth-card">

            <h1 class="auth-title">Create an Account</h1>

            <p class="auth-description">
                Join SkyBook and prepare for your next journey.
            </p>

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-red-100 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Registration form --}}
            <form
                method="POST"
                action="{{ route('register.store') }}"
                class="mt-6 space-y-4"
            >
                @csrf

                <div>
                    <label for="name" class="auth-label">
                        Full Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        required
                        autocomplete="name"
                        autofocus
                        class="auth-input"
                    >
                </div>

                <div>
                    <label for="email" class="auth-label">
                        Email Address
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email address"
                        required
                        autocomplete="email"
                        class="auth-input"
                    >
                </div>
                
                <div>
                    <label for="phone_number" class="auth-label">
                         Phone Number
                    </label>

                        <input
                            id="phone_number"
                            name="phone_number"
                            type="tel"
                            value="{{ old('phone_number') }}"
                            placeholder="+254712345678"
                            required
                            autocomplete="tel"
                            pattern="\+254[17][0-9]{8}"
                            title="Enter a Kenyan mobile number starting with +254"
                            class="auth-input"
                        >

            <p class="mt-1 text-sm text-gray-500">
                     Use the international format, e.g. +254712345678.
                </p>
                </div>


                <div>
                    <label for="password" class="auth-label">
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Create a password"
                        required
                        autocomplete="new-password"
                        class="auth-input"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="auth-label">
                        Confirm Password
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Enter your password again"
                        required
                        autocomplete="new-password"
                        class="auth-input"
                    >
                </div>

                <button type="submit" class="auth-button">
                    Create Account
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">
                    Log In
                </a>
            </p>

            <p class="mt-4 text-center text-gray-600">
                <a href="{{ url('/') }}" class="auth-link">
                    Back to SkyBook Home
                </a>
            </p>

        </div>
    </main>

</body>
</html>
