<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

// AUTH ROUTES
require __DIR__.'/auth.php';

// USER ROUTES
require __DIR__.'/user.php';

// ADMIN ROUTES
require __DIR__.'/admin.php';


// Tag Routes (API)
Route::controller(TagController::class)->prefix('tags')->name('tags.')->group(function () {
    Route::get('/search', 'search')->name('search');
    Route::post('/create', 'store')->name('store');
});