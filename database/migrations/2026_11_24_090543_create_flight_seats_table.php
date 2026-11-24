<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_seats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('flight_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('seat_number');

            $table->enum('travel_class', [
                'economy',
                'business',
                'first_class'
            ]);

            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->unique(['flight_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_seats');
    }
};