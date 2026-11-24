<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            
            $table->string('origin_code', 3);
            $table->string('origin_city');
            $table->string('destination_code', 3);
            $table->string('destination_city');
            $table->string('route_type', 20);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->unique
            (['origin_code', 'destination_code', ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
