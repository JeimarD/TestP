<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('products', ProductController::class);

    Route::prefix('products/{product}')->group(function () {
        Route::get('prices', [ProductPriceController::class, 'index']);
        Route::post('prices', [ProductPriceController::class, 'store']);
    });
});