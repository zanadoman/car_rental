<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
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
