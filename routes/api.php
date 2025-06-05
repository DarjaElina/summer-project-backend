<?php

use App\Http\Controllers\API\AuthUser;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::controller(AuthUser::class)->group(function () {
    Route::post('signup', 'signup')->name('signup.store');
    Route::post('login', 'login')->name('login.store');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:sanctum');
});

// Contact form route
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Event routes
    Route::apiResource('events', EventController::class);
});
