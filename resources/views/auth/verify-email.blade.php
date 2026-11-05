 
@extends('app.css')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            Verify your email address
        </h1>

        <p class="text-gray-600 mb-6">
            Thank you for registering with SkyBook! Before continuing,
            please verify your email address using the link we sent you.
        </p>

        @if (session('status') === 'verification-link-sent')
            <p class="text-green-600 mb-4">
                A new verification link has been sent to your email address.
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit"
                class="w-full rounded-lg bg-blue-600 px-4 py-3 text-white hover:bg-blue-700">
                Resend verification email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf

            <button type="submit" class="text-sm text-gray-600 hover:underline">
                Log out
            </button>
        </form>
    </div>
</div>
@endsection