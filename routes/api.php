<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->group(function () {
// Get all users
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

// Get specific user
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show');

// Add new user
Route::post('/users/store', [UserController::class, 'store'])
    ->name('users.store');

// Edit specific user
Route::put('/users/{id}/update', [UserController::class, 'update'])
    ->name('users.update');

// Delete specific user
Route::delete('/users/{id}/destroy', [UserController::class, 'destroy'])
    ->name('users.destroy');
// });
