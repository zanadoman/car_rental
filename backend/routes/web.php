<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/status', [Controller::class, 'index']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['role:customer,mechanic,salesman,admin'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
