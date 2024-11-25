<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'kilometers',
        'begin',
        'end',
        'delay',
        'totalfee',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];
}
