<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Flight;  
use App\Observers\FlightObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Flight::observe(FlightObserver::class);
    }
}
