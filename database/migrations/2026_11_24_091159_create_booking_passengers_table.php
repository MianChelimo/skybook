<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_passengers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('flight_seat_id')
                ->constrained('flight_seats')
                ->restrictOnDelete();

            $table->string('first_name');
            $table->string('last_name');

            $table->timestamps();

            $table->unique('flight_seat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_passengers');
    }
};