<?php

use App\Http\Controllers\API\AuthUser;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\EventController as ControllersEventController;
use Illuminate\Foundation\Console\ApiInstallCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('signup', function () {
    return view('signup');
})->name('signup');
Route::post('signup', [AuthUser::class, 'signup'])->name('signup-controller');
// Auth routes
Route::controller(AuthUser::class)->group(function () {
    Route::post('signup', 'signup')->name('signup.store');
    Route::post('login', 'login')->name('login.store');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:sanctum');
});

// Contact form route
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/events/public', [EventController::class, 'publicEvents']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Event routes
    // Route::apiResource('events', EventController::class);
});

Route::get('login', function () {
    return view('login');
})->name('login');
Route::post('login', [AuthUser::class, 'login'])->name('login-controller');


Route::post('logout', [AuthUser::class, 'logout'])->name('logout')->middleware('auth:sanctum');

//Routes for the Events here

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});

