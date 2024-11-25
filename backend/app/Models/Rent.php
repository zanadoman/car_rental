<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
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
        'updated_at'
    ];
}
