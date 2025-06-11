<?php

use App\Http\Controllers\API\AuthUser;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth API routes
Route::controller(AuthUser::class)->group(function () {
    Route::post('signup', 'signup')->name('signup.store');
    Route::post('login', 'login')->name('login.store');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

// Contact form API route
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

// Public event routes (no auth)
Route::get('events/public', [EventController::class, 'publicEvents']);
Route::get('events/public/{id}', [EventController::class, 'showPublic']);

// Protected routes (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // Events API resource
    Route::get('events', [EventController::class, 'index']);
    Route::post('events', [EventController::class, 'store']);
    Route::get('events/{id}', [EventController::class, 'show']);
    Route::put('events/{id}', [EventController::class, 'update']);
    Route::delete('events/{id}', [EventController::class, 'destroy']);
});


