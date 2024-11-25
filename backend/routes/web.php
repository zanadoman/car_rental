<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

Route::get('/status', [Controller::class, 'status']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['role:customer,mechanic,salesman,admin'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/cars', [CarController::class, 'index']);
});

Route::middleware(['role:customer,salesman,admin'])->group(function () {
    Route::get('/receipts', [ReceiptController::class, 'index']);
});

Route::middleware(['role:mechanic,admin'])->group(function () {
    Route::patch('/car/{id}', [CarController::class, 'edit']);
});

Route::middleware(['role:salesman,admin'])->group(function () {
    Route::get('/receipts', [ReceiptController::class, 'store']);
});

Route::middleware(['role:admin'])->group(function () {
    Route::post('/cars', [CarController::class, 'store']);
    Route::put('/receipt/{id}', [ReceiptController::class, 'update']);
    Route::delete('/receipt/{id}', [ReceiptController::class, 'destroy']);
    Route::put('/car/{id}', [CarController::class, 'update']);
    Route::delete('/car/{id}', [CarController::class, 'destroy']);
});
