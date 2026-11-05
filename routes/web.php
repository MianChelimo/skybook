
<
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\FlightController;
use App\Http\Controllers\PhoneOtpController;
use App\Http\Controllers\Admin\FlightController as AdminFlightController;
use App\Http\Controllers\BookingController;

// SkyBook homepage
Route::get('/', function () {
    return view('welcome');
});

// Search available flights
Route::get('/flights/search', [FlightController::class, 'search'])
    ->name('flights.search');

// Dashboard after login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Phone OTP verification
Route::get('/phone-otp', [PhoneOtpController::class, 'show'])
    ->name('phone-otp.show');

Route::post('/phone-otp', [PhoneOtpController::class, 'verify'])
    ->middleware('throttle:5,1')
    ->name('phone-otp.verify');

// Email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification link handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Administrator section
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('flights', AdminFlightController::class);
    });
// Customer booking routes
Route::middleware('auth')->group(function () {
    Route::get('/flights/{flight}/book', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/flights/{flight}/book', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');
    Route::get('/available-flights', [FlightController::class, 'available'])
    ->name('flights.available');    
});




