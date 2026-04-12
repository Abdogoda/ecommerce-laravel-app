<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileAvatarController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\VerifyAccountController;
use App\Http\Controllers\Auth\VerifyAccountRequestController;
use Illuminate\Support\Facades\Route;

// GUEST ROUTES
Route::middleware('guest')->group(function(){
    Route::view('/login', 'pages.auth.login')->name('login');
    Route::post('login', LoginController::class);

    Route::view('/register', 'pages.auth.register')->name('register');
    Route::post('register', RegisterController::class);

    Route::view('/forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Route::post("/forgot-password", ForgotPasswordController::class)->name('password.email');

    Route::view('/reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
    Route::post("/reset-password", ResetPasswordController::class)->name('password.update');
});

// AUTHENTICATED USER ROUTES
Route::middleware('auth')->group(function(){
    Route::put('profile', [UpdateProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/avatar', [ProfileAvatarController::class, 'update'])->name('profile.avatar.update');
    Route::delete('profile/avatar', [ProfileAvatarController::class, 'destroy'])->name('profile.avatar.delete');
    
    Route::post('change-password', ChangePasswordController::class)->name('password.change');
    Route::post('/verify-email-request', VerifyAccountRequestController::class)->name('email.request');

    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('logout-other-devices', [LogoutController::class, 'logoutOtherDevices'])->name('logout.other-devices');
    Route::post('delete-account', [UpdateProfileController::class, 'destroy'])->name('account.delete');
});

// EMAIL VERIFICATION ROUTES
Route::view("/verify-email/{email}", 'pages.auth.verify-email')->name('email.verify');
Route::post("/verify-email", VerifyAccountController::class);