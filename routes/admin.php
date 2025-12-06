<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DiscountsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\UsersController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('/products', ProductController::class);
    
    // Orders
    Route::resource('/orders', OrderController::class); 
    
    // Discounts
    Route::resource('/discounts', DiscountsController::class);
    
    // Users - CHỈ customer và admin
    Route::resource('/users', UsersController::class)->except(['show']); // Không dùng show nếu không cần
    
    // Payments
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('/payments/revenue', [PaymentsController::class, 'revenue'])->name('payments.revenue');
    Route::get('/payments/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}/status', [PaymentsController::class, 'updateStatus'])->name('payments.updateStatus');
});