<?php

use App\Http\Controllers\API\AuthUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// View routes
Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/login', function () {
    return view('login');
})->name('login');
