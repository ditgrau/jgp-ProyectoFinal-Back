<?php

use App\Http\Controllers\AuthController\Login;
use App\Http\Controllers\AuthController\Register;
use App\Http\Controllers\Event_typeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\User_groupController;
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
Route::get('/getMyGroups', [GroupController::class, 'getMyGroups'])->middleware('auth:sanctum');;
Route::get('/getUsersByGroup/{id}', [GroupController::class, 'getUsersByGroup'])->middleware('auth:sanctum');

// ROLES CONTROLLER
Route::get('/getAllRoles', [RoleController::class, 'getAllRoles'])->middleware('auth:sanctum', 'isAdmin');

// USER CONTROLLER
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::put('/updateProfile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::get('/getAverage', [UserController::class, 'getAverage'])->middleware('auth:sanctum');
Route::get('/clubAverage', [UserController::class, 'clubAverage'])->middleware('auth:sanctum');
Route::put('/updateCredentials', [UserController::class, 'updateCredentials'])->middleware('auth:sanctum');

// USER CONTROLLER - ADMIN
Route::get('/getUserUnconfirmed/{confirmed}', [UserAdminController::class, 'getUserUnconfirmed'])->middleware('auth:sanctum', 'isAdmin');
Route::put('/updateConfirmation/{id}', [UserAdminController::class, 'updateConfirmation'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/getAllUsers', [UserAdminController::class, 'getAllUsers'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/getUserByName/{name}', [UserAdminController::class, 'getUserByName'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/getUserById/{id}', [UserAdminController::class, 'getUserById'])->middleware('auth:sanctum', 'isAdmin');
Route::delete('/deleteUserById/{id}', [UserAdminController::class, 'deleteUserById'])->middleware('auth:sanctum', 'isAdmin');
Route::put('/updateUser/{id}', [UserAdminController::class, 'updateUser'])->middleware('auth:sanctum', 'isAdmin');

// EVENT CONTROLLER
Route::get('/getAllEvents', [EventController::class, 'getAllEvents'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/getMyEvents', [EventController::class, 'getMyEvents'])->middleware('auth:sanctum');
Route::get('/myEventById/{id}', [EventController::class, 'myEventById'])->middleware('auth:sanctum');
Route::get('/getEventById/{id}', [EventController::class, 'getEventById'])->middleware('auth:sanctum');
Route::get('/getEventsByType/{id}', [EventController::class, 'getEventsByType'])->middleware('auth:sanctum');
Route::get('/myEventsByType/{id}', [EventController::class, 'myEventsByType'])->middleware('auth:sanctum');
Route::post('/newEvent', [EventController::class, 'newEvent'])->middleware('auth:sanctum, isAdmin');

// RESULT CONTROLLER
Route::get('/getAllResults', [ResultController::class, 'getAllResults'])->middleware('auth:sanctum');
Route::get('/getMyResults', [ResultController::class, 'getMyResults'])->middleware('auth:sanctum');
Route::get('/myLastResults', [ResultController::class, 'myLastResults'])->middleware('auth:sanctum');
Route::get('/getResultById/{id}', [ResultController::class, 'getResultById'])->middleware('auth:sanctum');
Route::delete('/deleteResult/{id}', [ResultController::class, 'deleteResult'])->middleware('auth:sanctum');
Route::post('/addResult', [ResultController::class, 'addResult'])->middleware('auth:sanctum');

// EVENT_TYPE CONTROLLER
Route::get('/getAllEventTypes', [Event_typeController::class, 'getAllEventTypes'])->middleware('auth:sanctum', 'isAdmin');

// USER_GROUP CONTROLLER
Route::get('/usersByGroupId/{id}', [User_groupController::class, 'usersByGroupId'])->middleware('auth:sanctum', 'isAdmin');