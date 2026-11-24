<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    protected $fillable = [
        'origin_code',
        'origin_city',
        'destination_code',
        'destination_city',
        'route_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }
}