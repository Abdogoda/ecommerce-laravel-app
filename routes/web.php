<?php

use Illuminate\Support\Facades\Route;

// STATIC PAGES ROUTES
// TODO: Replace with dynamic routes and controllers when implementing functionality
Route::view('/', 'pages.user.home')->name('home');
Route::view('/categories', 'pages.user.categories')->name('categories');
Route::view('/products', 'pages.user.products')->name('products.index');
Route::view('/products/{id}', 'pages.user.products')->name('products.show');
Route::view('/cart', 'pages.user.cart')->name('cart');
Route::view('/checkout', 'pages.user.checkout')->name('checkout');
Route::view('/profile', 'pages.user.profile')->name('profile');
Route::view('/order', 'pages.user.order')->name('order');

// ADMIN ROUTES
Route::view('/admin', 'pages.admin.dashboard')->name('admin.dashboard');
Route::view('/admin/products', 'pages.admin.products')->name('admin.products');
Route::view('/admin/products/create', 'pages.admin.create_product')->name('admin.products.create');
Route::view('/admin/products/{id}/edit', 'pages.admin.edit_product')->name('admin.products.edit');
Route::view('/admin/categories', 'pages.admin.categories')->name('admin.categories');
Route::view('/admin/categories/create', 'pages.admin.create_category')->name('admin.categories.create');
Route::view('/admin/categories/{id}/edit', 'pages.admin.edit_category')->name('admin.categories.edit');
Route::view('/admin/orders', 'pages.admin.orders')->name('admin.orders');
Route::view('/admin/orders/{id}', 'pages.admin.order_details')->name('admin.orders.show');
Route::view('/admin/users', 'pages.admin.users')->name('admin.users');
Route::view('/admin/users/{id}/edit', 'pages.admin.edit_user')->name('admin.users.edit');

// AUTH ROUTES
Route::view('/login', 'pages.auth.login')->name('login');
Route::view('/register', 'pages.auth.register')->name('register');
Route::view('/password/reset', 'pages.auth.passwords.email')->name('password.request');
Route::view('/password/reset/{token}', 'pages.auth.passwords.reset')->name('password.reset');