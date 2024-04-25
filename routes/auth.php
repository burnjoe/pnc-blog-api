<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register related auth routes for your application. 
| These routes are then included in the api routes. This is made to 
| organize routes made only for authentication related functions.
|
*/


// Login 
Route::post('/login', [AuthController::class, 'login']);

// Register User 
Route::post('/register', [AuthController::class, 'register']);

// Forgot Password
Route::post('/forgot-password', [ForgotController::class, 'forgetPassword']);

// Reset Password
Route::post('/reset-password', [ResetController::class, 'resetPassword']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api']);