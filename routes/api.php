<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// ============================== Authenticated Users ==============================
Route::middleware(['auth:api'])->group(function () {
    // ============================== Users ==============================

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


    // ============================== Posts ==============================

    // Add new post
    Route::post('/posts/store', [PostController::class, 'store'])
        ->name('posts.store');

    // Edit specific post
    Route::put('/posts/{id}/update', [PostController::class, 'update'])
        ->name('posts.update');

    // Delete specific post
    Route::delete('/posts/{id}/destroy', [PostController::class, 'destroy'])
        ->name('posts.destroy');


    // ============================== Follows ==============================

    // Follow new writer
    Route::post('/follow/{id}', [FollowController::class, 'follow'])
        ->name('follow');

    // Unfollow specific writer
    Route::delete('/unfollow/{id}', [FollowController::class, 'unfollow'])
        ->name('unfollow');
});


// ============================== Guests ==============================
// ============================== Follows ==============================

// Get user followings
Route::get('/users/{id}/following', [UserController::class, 'showFollowing'])
    ->name('users.following');

// Get user followers
Route::get('/users/{id}/followers', [UserController::class, 'showFollowers'])
    ->name('users.followers');

// ============================== Posts ==============================

// Get all posts
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

// Get specific post
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');


// Include authentication routes
require __DIR__ . '/auth.php';
