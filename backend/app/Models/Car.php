<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    protected $fillable = [
        'license',
        'brand',
        'category',
        'kilometers',
        'dailyfee',
        'last_maintenance',
        'next_maintenance',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
