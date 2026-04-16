<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

// USER STATIC ROUTES
Route::get('/', HomeController::class)->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::view('/products', 'pages.user.products')->name('products.index');
Route::view('/products/{id}', 'pages.user.products')->name('products.show');
Route::view('/cart', 'pages.user.cart')->name('cart');

Route::post('contact', ContactController::class)->name('contact.store');

// USER PROTECTED ROUTES
Route::middleware('auth')->group(function(){
    Route::view('/checkout', 'pages.user.checkout')->name('checkout');
    Route::view('/profile', 'pages.user.profile')->name('profile');
    Route::view('/order', 'pages.user.order')->name('order');
});