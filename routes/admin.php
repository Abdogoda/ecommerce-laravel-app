<?php

use Illuminate\Support\Facades\Route;
use App\Enums\PermissionEnum;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'can:'.PermissionEnum::VIEW_DASHBOARD->value])->prefix('admin')->name('admin.')->group(function(){
    Route::view('/', 'pages.admin.dashboard')->name('dashboard');

    // User management routes
    Route::controller(UserController::class)->middleware(['can:'.PermissionEnum::VIEW_USERS->value])->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/', 'store')->name('store')->middleware(['can:'.PermissionEnum::CREATE_USERS->value]);
        Route::get('/{user}/edit', 'edit')->name('edit')->middleware(['can:'.PermissionEnum::EDIT_USERS->value]);
        Route::put('/{user}', 'update')->name('update')->middleware(['can:'.PermissionEnum::EDIT_USERS->value]);
        Route::put('/{user}/roles', 'assignRole')->name('assignRole')->middleware(['can:'.PermissionEnum::ASSIGN_ROLES->value]);
        Route::delete('/{user}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_USERS->value]);
    });

    // Role management routes
    Route::controller(RoleController::class)->middleware(['can:'.PermissionEnum::VIEW_ROLES->value])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware(['can:'.PermissionEnum::CREATE_ROLES->value]);
        Route::put('/{role}', 'update')->name('update')->middleware(['can:'.PermissionEnum::EDIT_ROLES->value]);
        Route::put('/{role}/permissions', 'updatePermissions')->name('updatePermissions')->middleware(['can:'.PermissionEnum::EDIT_ROLES->value]);
        Route::delete('/{role}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_ROLES->value]);
    });

    Route::view('products', 'pages.admin.products')->name('products.index');
    Route::view('products/create', 'pages.admin.create_product')->name('products.create');
    Route::view('products/{id}/edit', 'pages.admin.edit_product')->name('products.edit');
    Route::view('categories', 'pages.admin.categories')->name('categories.index');
    Route::view('categories/create', 'pages.admin.create_category')->name('categories.create');
    Route::view('categories/{id}/edit', 'pages.admin.edit_category')->name('categories.edit');
    Route::view('orders', 'pages.admin.orders')->name('orders.index');
    Route::view('orders/{id}', 'pages.admin.order_details')->name('orders.show');
    Route::view('messages', 'pages.admin.messages')->name('messages.index');
    Route::view('profile', 'pages.admin.profile')->name('profile');
});