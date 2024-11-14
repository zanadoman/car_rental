<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/status', function () {
    return view('welcome');
});

Route::middleware(['role:customer,mechanic,salesman,admin'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
