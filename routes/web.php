
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PhoneOtpController;

// SkyBook homepage
Route::get('/', function () {return view('welcome');
});
    
// Search available flights
Route::get('/flights/search', [FlightController::class, 'search']) ->name('flights.search');
   
//display dashboard after login
Route::get('/dashboard', function () { return view('dashboard');})->middleware('auth')->name('dashboard');

   // Phone OTP verification
Route::get('/phone-otp', [PhoneOtpController::class, 'show'])->name('phone-otp.show');
    
Route::post('/phone-otp', [PhoneOtpController::class, 'verify'])->middleware('throttle:5,1')
    ->name('phone-otp.verify');
    

    

