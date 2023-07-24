<?php

use App\Http\Controllers\AuthController\Login;
use App\Http\Controllers\AuthController\Register;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/welcome', function () {
    return 'Bienvenidos a mi app';
});

// AUTH CONTROLLER
Route::post('/register', Register::class);
Route::post('/login', Login::class);

// GROUPS CONTROLLER
Route::get('/getAllGroups', [GroupController::class, 'getAllGroups']);

// ROLES CONTROLLER
Route::get('/getAllRoles', [RoleController::class, 'getAllRoles'])->middleware('auth:sanctum');

// USER CONTROLLER
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::put('/updateProfile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

// USER CONTROLLER - ADMIN
Route::get('/getUserUnconfirmed/{confirmed}', [UserAdminController::class, 'getUserUnconfirmed'])->middleware('auth:sanctum');
Route::put('/updateConfirmation/{id}', [UserAdminController::class, 'updateConfirmation'])->middleware('auth:sanctum');
Route::get('/getAllUsers', [UserAdminController::class, 'getAllUsers'])->middleware('auth:sanctum');

// EVENT CONTROLLER
Route::get('/getAllEvents', [EventController::class, 'getAllEvents'])->middleware('auth:sanctum');
Route::get('/getMyEvents', [EventController::class, 'getMyEvents'])->middleware('auth:sanctum');

// RESULT CONTROLLER
Route::get('/getAllResults', [ResultController::class, 'getAllResults'])->middleware('auth:sanctum');
Route::get('/getMyResults', [ResultController::class, 'getMyResults'])->middleware('auth:sanctum');
