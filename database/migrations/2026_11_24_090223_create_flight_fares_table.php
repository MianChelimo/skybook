<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_fares', function (Blueprint $table) {
            $table->id();

            $table->foreignId('flight_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('travel_class', [
                'economy',
                'business',
                'first_class'
            ]);

            $table->decimal('price', 10, 2);

            $table->timestamps();

            $table->unique(['flight_id', 'travel_class']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_fares');
    }
};
