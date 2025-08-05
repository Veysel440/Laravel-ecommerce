<?php

use App\Http\Controllers\Api\AdminCampaignController;
use App\Http\Controllers\Api\AdminShippingController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update/{id}', [CartController::class, 'update']);
    Route::delete('/remove/{id}', [CartController::class, 'remove']);
    Route::delete('/clear', [CartController::class, 'clear']);
});

Route::middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::post('/{id}/pay', [OrderController::class, 'pay']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('admin/campaigns', AdminCampaignController::class);
    Route::post('admin/campaigns/{id}/activate', [AdminCampaignController::class, 'activate']);
    Route::post('admin/campaigns/{id}/deactivate', [AdminCampaignController::class, 'deactivate']);
});
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('admin/shipping', AdminShippingController::class);
});
