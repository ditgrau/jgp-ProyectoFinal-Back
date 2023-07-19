<?php

use App\Http\Controllers\AuthController\Login;
use App\Http\Controllers\AuthController\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/welcome', function () {
    return 'Bienvenidos a mi app';
});

// AUTH CONTROLLER
Route::post('/register', Register::class);
Route::post('/login', Login::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
