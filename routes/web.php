<?php

use Illuminate\Support\Facades\Route;

// AUTH ROUTES
require __DIR__.'/auth.php';

// USER ROUTES
require __DIR__.'/user.php';

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