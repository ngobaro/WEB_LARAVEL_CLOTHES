<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DiscountsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PaymentsController; // THÊM PAYMENTS

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('/products', ProductController::class);
    
    // Orders
    Route::resource('/orders', OrderController::class); 
    
    // Discounts
    Route::resource('/discounts', DiscountsController::class);
    
    // Payments - CHỈ XEM VÀ THỐNG KÊ
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('/payments/revenue', [PaymentsController::class, 'revenue'])->name('payments.revenue');
    Route::get('/payments/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}/status', [PaymentsController::class, 'updateStatus'])->name('payments.updateStatus');
    
    // KHÔNG CÓ: payments.create, payments.store, payments.edit, payments.update, payments.destroy
});