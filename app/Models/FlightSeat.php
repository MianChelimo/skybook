<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FlightSeat extends Model
{
    protected $fillable = [
        'flight_id',
        'seat_number',
        'travel_class',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function passenger(): HasOne
    {
        return $this->hasOne(BookingPassenger::class);
    }
}