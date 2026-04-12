<?php

use Illuminate\Support\Facades\Route;
use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:'.PermissionEnum::VIEW_DASHBOARD->value])->group(function(){
    Route::view('/admin', 'pages.admin.dashboard')->name('admin.dashboard');

    Route::view('/admin/products', 'pages.admin.products')->name('admin.products.index');
    Route::view('/admin/products/create', 'pages.admin.create_product')->name('admin.products.create');
    Route::view('/admin/products/{id}/edit', 'pages.admin.edit_product')->name('admin.products.edit');
    Route::view('/admin/categories', 'pages.admin.categories')->name('admin.categories.index');
    Route::view('/admin/categories/create', 'pages.admin.create_category')->name('admin.categories.create');
    Route::view('/admin/categories/{id}/edit', 'pages.admin.edit_category')->name('admin.categories.edit');
    Route::view('/admin/orders', 'pages.admin.orders')->name('admin.orders.index');
    Route::view('/admin/orders/{id}', 'pages.admin.order_details')->name('admin.orders.show');
    Route::view('/admin/users', 'pages.admin.users')->name('admin.users.index');
    Route::view('/admin/users/{id}/edit', 'pages.admin.edit_user')->name('admin.users.edit');
    Route::view('/admin/roles', 'pages.admin.roles')->name('admin.roles.index');
    Route::view('/admin/messages', 'pages.admin.messages')->name('admin.messages.index');
    Route::view('/admin/profile', 'pages.admin.profile')->name('admin.profile');
});