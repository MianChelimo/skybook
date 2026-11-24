

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\FlightController;

use App\Http\Controllers\Admin\FlightController as AdminFlightController;
use App\Http\Controllers\BookingController;

// SkyBook homepage
Route::get('/', function () {
    return view('welcome');
});

// Search available flights
Route::get('/flights/search', [FlightController::class, 'search'])

    ->name('flights.search');

    // after registration, redirect to login page
Route::get('/register/success', function () {
    return view('auth.register-success');
})->name('register.success');

// Dashboard after login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware('auth')->name('dashboard');



// Email verification link handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend verification email
//

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
    // passenger details page
    Route::get('/flights/{flight}/book', [BookingController::class, 'create'])
        ->name('bookings.create');
    // save passengers details and proceed to seat selection
    Route::post('/flights/{flight}/book', [BookingController::class, 'store'])
        ->name('bookings.store');
     // Seat selection page
Route::get('/flights/{flight}/book/seats', [BookingController::class, 'seats'])
    ->name('bookings.seats');
    // save selected seats 
Route::post('/flights/{flight}/book/seats', [BookingController::class, 'storeSeats'])
    ->name('bookings.seats.store');
    // Booking summary page
Route::get('/flights/{flight}/book/summary', [BookingController::class, 'summary'])
    ->name('bookings.summary');
    // Confirm and save booking
Route::post('/flights/{flight}/book/confirm', [BookingController::class, 'store'])
    ->name('bookings.store');
    //display confirmed booking details
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');
        
        Route::post('/flights/{flight}/book/passengers', [BookingController::class, 'storePassengers'])
    ->name('bookings.passengers.store');
        // available flights
    Route::get('/available-flights', [FlightController::class, 'available'])
    ->name('flights.available');    
});







