<?php

use App\Http\Controllers\API\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('signup', function () {
    return view('signup');
})->name('signup');
Route::post('signup', [AuthUser::class, 'signup'])->name('signup-controller');

Route::get('login', function () {
    return view('login');
})->name('login');
Route::post('login', [AuthUser::class, 'login'])->name('login-controller');


Route::post('logout', [AuthUser::class, 'logout'])->name('logout')->middleware('auth:sanctum');
