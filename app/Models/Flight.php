<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'airline',
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime',
            'arrival_time' => 'datetime',
            'price' => 'decimal:2',
            'available_seats' => 'integer',
        ];
    }
}
