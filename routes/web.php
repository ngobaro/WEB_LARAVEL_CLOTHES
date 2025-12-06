<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisterController;

// Routes công khai (không cần login)
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginStandard'])->name('login');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Group routes cần login (redirect /login nếu chưa auth)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');  // Trang chủ sau login
    });

    // Routes admin (đã có 'admin' middleware từ trước)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('/products', ProductController::class);
    });
});