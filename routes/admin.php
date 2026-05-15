<?php

use Illuminate\Support\Facades\Route;
use App\Enums\PermissionEnum;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\OrderController;

Route::middleware(['auth', 'can:'.PermissionEnum::VIEW_DASHBOARD->value])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/', DashboardController::class)->name('dashboard');
    
    Route::view('profile', 'pages.admin.profile')->name('profile');
    
    Route::get('search', SearchController::class)->name('search')->middleware('throttle:60,1');

    // User management routes
    Route::controller(UserController::class)->middleware(['can:'.PermissionEnum::VIEW_USERS->value])->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/', 'store')->name('store')->middleware(['can:'.PermissionEnum::CREATE_USERS->value]);
        Route::get('/{user}/edit', 'edit')->name('edit')->middleware(['can:'.PermissionEnum::EDIT_USERS->value]);
        Route::put('/{user}', 'update')->name('update')->middleware(['can:'.PermissionEnum::EDIT_USERS->value]);
        Route::put('/{user}/roles', 'assignRole')->name('assignRole')->middleware(['can:'.PermissionEnum::ASSIGN_ROLES->value]);
        Route::delete('/{user}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_USERS->value]);
        Route::get('/export/filtered', 'exportFiltered')->name('exportFiltered');
        Route::get('/export/all', 'exportAll')->name('exportAll');
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
        Route::get('/export/filtered', 'exportFiltered')->name('exportFiltered');
        Route::get('/export/all', 'exportAll')->name('exportAll');
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
        Route::get('/export/filtered', 'exportFiltered')->name('exportFiltered');
        Route::get('/export/all', 'exportAll')->name('exportAll');
    });

    // Settings Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->middleware(['can:'.PermissionEnum::VIEW_SETTINGS->value])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/general', 'updateGeneral')->name('updateGeneral')->middleware(['can:'.PermissionEnum::EDIT_GENERAL_SETTINGS->value]);
        Route::post('/order', 'updateOrder')->name('updateOrder')->middleware(['can:'.PermissionEnum::EDIT_ORDER_SETTINGS->value]);
        Route::post('/social', 'updateSocial')->name('updateSocial')->middleware(['can:'.PermissionEnum::EDIT_SOCIAL_SETTINGS->value]);
        Route::post('/notifications', 'updateNotifications')->name('updateNotifications')->middleware(['can:'.PermissionEnum::EDIT_NOTIFICATION_SETTINGS->value]);
    });

    // Notification Routes
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{notification}', 'show')->name('show');
        Route::delete('/{notification}', 'destroy')->name('destroy');
        Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
        Route::post('/delete-multiple', 'deleteMultiple')->name('deleteMultiple');
    });

    // Message Routes
    Route::controller(MessageController::class)->prefix('messages')->name('messages.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{message}', 'show')->name('show');
        Route::put('/{message}', 'update')->name('update');
        Route::delete('/{message}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_MESSAGES->value]);
        Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
        Route::post('/delete-multiple', 'deleteMultiple')->name('deleteMultiple');
    });

    // Order Routes
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->middleware(['can:'.PermissionEnum::VIEW_ORDERS->value])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::put('/{order}/status', 'updateStatus')->name('updateStatus')->middleware(['can:'.PermissionEnum::EDIT_ORDERS->value]);
        Route::delete('/{order}', 'destroy')->name('destroy')->middleware(['can:'.PermissionEnum::DELETE_ORDERS->value]);
    });
});