<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;

Route::get('/status', [Controller::class, 'status']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['role:customer,mechanic,salesman,admin'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/cars', [CarController::class, 'index']);
});

Route::middleware(['role:customer,salesman,admin'])->group(function () {
    Route::get('/rent/{id}', [RentController::class, 'show']);
    Route::get('/rents', [RentController::class, 'index']);
    Route::patch('/rent/{id}', [RentController::class, 'edit']);
    Route::get('/receipts', [ReceiptController::class, 'index']);
});

Route::middleware(['role:customer,admin'])->group(function () {
    Route::post('/rents', [RentController::class, 'store']);
});

Route::middleware(['role:mechanic,admin'])->group(function () {
    Route::patch('/car/{id}', [CarController::class, 'edit']);
});

Route::middleware(['role:salesman,admin'])->group(function () {
    Route::post('/receipts', [ReceiptController::class, 'store']);
});

Route::middleware(['role:admin'])->group(function () {
    Route::post('/cars', [CarController::class, 'store']);
    Route::put('/car/{id}', [CarController::class, 'update']);
    Route::delete('/car/{id}', [CarController::class, 'destroy']);
    Route::put('/rent/{id}', [RentController::class, 'update']);
    Route::delete('/rent/{id}', [RentController::class, 'destroy']);
    Route::put('/receipt/{id}', [ReceiptController::class, 'update']);
    Route::delete('/receipt/{id}', [ReceiptController::class, 'destroy']);
});
