<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class Controller
{
    public function status(): View
    {
        return view('welcome');
    }
}
