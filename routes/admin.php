<?php

use App\Http\Controllers\Api\AdminReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\AdminProductController;
use App\Http\Controllers\Api\AdminUserController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return response()->json([
            'total_orders' => \App\Models\Order::count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
            'total_users' => \App\Models\User::count(),
        ]);
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index']);
        Route::get('/{id}', [AdminOrderController::class, 'show']);
        Route::put('/{id}/status', [AdminOrderController::class, 'updateStatus']);
        Route::delete('/{id}', [AdminOrderController::class, 'destroy']);
    });


    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index']);
        Route::post('/', [AdminProductController::class, 'store']);
        Route::put('/{id}', [AdminProductController::class, 'update']);
        Route::delete('/{id}', [AdminProductController::class, 'destroy']);
    });


    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index']);
        Route::put('/{id}/update-type', [AdminUserController::class, 'updateType']);
        Route::delete('/{id}', [AdminUserController::class, 'destroy']);
    });


    Route::prefix('reports')->group(function () {
        Route::get('/summary', [AdminReportController::class, 'summary']);
        Route::get('/total-sales', [AdminReportController::class, 'totalSales']);
        Route::get('/total-orders', [AdminReportController::class, 'totalOrders']);
        Route::get('/total-users', [AdminReportController::class, 'totalUsers']);
    });
});
