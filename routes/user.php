<?php

use Illuminate\Support\Facades\Route;

// USER STATIC ROUTES
Route::view('/', 'pages.user.home')->name('home');
Route::view('/categories', 'pages.user.categories')->name('categories');
Route::view('/products', 'pages.user.products')->name('products.index');
Route::view('/products/{id}', 'pages.user.products')->name('products.show');
Route::view('/cart', 'pages.user.cart')->name('cart');

// USER PROTECTED ROUTES
Route::middleware('auth')->group(function(){
    Route::view('/checkout', 'pages.user.checkout')->name('checkout');
    Route::view('/profile', 'pages.user.profile')->name('profile');
    Route::view('/order', 'pages.user.order')->name('order');
});