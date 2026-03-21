<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderQueueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/ordering', [OrderingController::class, 'index'])->name('ordering.index');
    Route::post('/ordering/cart', [OrderingController::class, 'addToCart'])->name('ordering.cart.add');
    Route::patch('/ordering/cart/{product}/decrement', [OrderingController::class, 'decrementFromCart'])->name('ordering.cart.decrement');
    Route::delete('/ordering/cart/{product}', [OrderingController::class, 'removeFromCart'])->name('ordering.cart.remove');
    Route::post('/ordering/place-order', [OrderingController::class, 'placeOrder'])->name('ordering.place-order');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    Route::get('/order-queue', [OrderQueueController::class, 'index'])->name('order-queue.index');
    Route::post('/order-queue/{order}/finish', [OrderQueueController::class, 'finishOrder'])->name('order-queue.finish');
    Route::delete('/order-queue/{order}', [OrderQueueController::class, 'removeOrder'])->name('order-queue.remove');
    Route::post('/order-queue/{order}/restore', [OrderQueueController::class, 'restoreOrder'])->name('order-queue.restore');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});
