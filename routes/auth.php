<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\VerifyAccountController;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'pages.auth.login')->name('login');
Route::post('login', LoginController::class);

Route::view('/register', 'pages.auth.register')->name('register');
Route::post('register', RegisterController::class);

Route::view('/forgot-password', 'pages.auth.forgot-password')->name('password.request');
Route::post("/forgot-password", ForgotPasswordController::class)->name('password.email');

Route::view('/reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
Route::post("/reset-password", ResetPasswordController::class)->name('password.update');

Route::view("/verify-email/{email}", 'pages.auth.verify-email')->name('email.verify');
Route::post("/verify-email", VerifyAccountController::class);

Route::middleware('auth')->group(function(){
    Route::view('/profile', 'pages.auth.profile');
    Route::put('profile', UpdateProfileController::class);
    Route::post('change-password', ChangePasswordController::class);

    Route::post('logout', LogoutController::class)->name('logout');
});