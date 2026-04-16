<?php

use Illuminate\Support\Facades\Route;
use App\Enums\PermissionEnum;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MessageController;

Route::middleware(['auth', 'can:'.PermissionEnum::VIEW_DASHBOARD->value])->prefix('admin')->name('admin.')->group(function(){
    Route::view('/', 'pages.admin.dashboard')->name('dashboard');
    Route::view('profile', 'pages.admin.profile')->name('profile');

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

    // Activity log route
    Route::controller(ActivityController::class)->middleware(['can:'.PermissionEnum::VIEW_ACTIVITIES->value])->prefix('activities')->name('activities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'clear')->name('clear')->middleware(['can:'.PermissionEnum::CLEAR_ACTIVITIES->value]);
    });

    // Category Routes
    Route::controller(CategoryController::class)->middleware(['can:'.PermissionEnum::VIEW_CATEGORIES->value])->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{category}', 'show')->name('show');
        Route::post('/', 'store')->name('store')->middleware(['can:'.PermissionEnum::CREATE_CATEGORIES->value]);
        Route::put('/{category}', 'update')->name('update')->middleware(['can:'.PermissionEnum::EDIT_CATEGORIES->value]);
        Route::delete('/{category}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_CATEGORIES->value]);
    });

    // Product Routes
    Route::controller(ProductController::class)->middleware(['can:'.PermissionEnum::VIEW_PRODUCTS->value])->prefix('products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware(['can:'.PermissionEnum::CREATE_PRODUCTS->value]);
        
        Route::post('/{product}/images', 'storeImage')->name('images.store')->middleware(['can:'.PermissionEnum::EDIT_PRODUCTS->value]);
        Route::put('/{product}/images/{media}', 'updateImage')->name('images.update')->middleware(['can:'.PermissionEnum::EDIT_PRODUCTS->value]);
        Route::delete('/{product}/images/{media}', 'destroyImage')->name('images.destroy')->middleware(['can:'.PermissionEnum::EDIT_PRODUCTS->value]);
        
        Route::get('/{product}', 'show')->name('show');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware(['can:'.PermissionEnum::EDIT_PRODUCTS->value]);
        Route::put('/{product}', 'update')->name('update')->middleware(['can:'.PermissionEnum::EDIT_PRODUCTS->value]);
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_PRODUCTS->value]);
    });

    // Settings Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->middleware(['can:'.PermissionEnum::VIEW_SETTINGS->value])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/general', 'updateGeneral')->name('updateGeneral')->middleware(['can:'.PermissionEnum::EDIT_GENERAL_SETTINGS->value]);
        Route::post('/order', 'updateOrder')->name('updateOrder')->middleware(['can:'.PermissionEnum::EDIT_ORDER_SETTINGS->value]);
        Route::post('/social', 'updateSocial')->name('updateSocial')->middleware(['can:'.PermissionEnum::EDIT_SOCIAL_SETTINGS->value]);
        Route::post('/notifications', 'updateNotifications')->name('updateNotifications')->middleware(['can:'.PermissionEnum::EDIT_NOTIFICATION_SETTINGS->value]);
    });

    // Message Routes
    Route::controller(MessageController::class)->prefix('messages')->name('messages.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{message}', 'show')->name('show');
        Route::put('/{message}', 'update')->name('update');
        Route::delete('/{message}', 'destroy')->name('destroy');
        Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
        Route::post('/delete-multiple', 'deleteMultiple')->name('deleteMultiple');
    });

    Route::view('products/{id}/edit', 'pages.admin.edit_product')->name('products.edit');
    Route::view('orders', 'pages.admin.orders')->name('orders.index');
    Route::view('orders/{id}', 'pages.admin.order_details')->name('orders.show');
});