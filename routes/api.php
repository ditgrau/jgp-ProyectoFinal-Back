<?php

use App\Http\Controllers\AuthController\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH CONTROLLER
Route::post('/register', Register::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
