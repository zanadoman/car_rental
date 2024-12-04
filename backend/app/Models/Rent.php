<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rent extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    protected $fillable = [
        'user_id',
        'car_id',
        'kilometers',
        'begin',
        'end',
        'takeaway',
        'return',
        'active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
