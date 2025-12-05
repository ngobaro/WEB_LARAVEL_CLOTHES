<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisterController;


// Routes đăng nhập (email + pass trước, sau OTP)
Route::get('/login', [OtpController::class, 'showForm'])->name('login');  // GET form
Route::post('/login', [OtpController::class, 'loginAttempt'])->name('login.attempt');  // POST attempt pass

// Routes verify OTP
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');  // GET form verify
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');  // POST xử lý OTP

// Routes đăng ký
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard sau login
Route::middleware('auth')->get('/', function () {
    return view('home');
});
    

// Logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');