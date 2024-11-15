<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

abstract class Controller
{
    public function index(): View
    {
        return view('welcome');
    }
}
