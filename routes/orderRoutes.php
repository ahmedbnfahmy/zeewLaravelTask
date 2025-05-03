<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Order API endpoints
Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::put('/{id}', [OrderController::class, 'update']);
    Route::get('/stats', [OrderController::class, 'stats']);
});