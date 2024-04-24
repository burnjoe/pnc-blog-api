<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Login 
Route::post('/login', [AuthController::class, 'login']);

// Register User 
Route::post('/register', [AuthController::class, 'register']);

// Forgot Password
Route::post('/forgot-password', [ForgotController::class, 'forgetPassword']);

// Reset Password
Route::post('/reset-password', [ResetController::class, 'resetPassword']);


Route::middleware(['auth:api'])->group(function () {
    // // Get all users
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
});



// // Get specific user
// Route::get('/users/{id}', [UserController::class, 'show'])
//     ->name('users.show');

// // Add new user
// Route::post('/users/store', [UserController::class, 'store'])
//     ->name('users.store');

// // Edit specific user
// Route::put('/users/{id}/update', [UserController::class, 'update'])
//     ->name('users.update');

// // Delete specific user
// Route::delete('/users/{id}/destroy', [UserController::class, 'destroy'])
//     ->name('users.destroy');


// // Get user followings
// Route::get('/users/{id}/following', [UserController::class, 'showFollowing'])
//     ->name('users.following');

// // Get user followers
// Route::get('/users/{id}/followers', [UserController::class, 'showFollowers'])
//     ->name('users.followers');

// // Follow new writer
// Route::post('/follow/{id}', [FollowController::class, 'store'])
//     ->name('follow');

// // Unfollow specific writer
// Route::delete('/unfollow/{id}', [FollowController::class, 'destroy'])
//     ->name('unfollow');
    


// Get all posts
// Route::get('/posts', [PostController::class, 'index'])
//     ->name('posts.index');

// // Get specific post
// Route::get('/posts/{id}', [PostController::class, 'show'])
//     ->name('posts.show');

// // Add new post
// Route::post('/posts/store', [PostController::class, 'store'])
//     ->name('posts.store');

// // Edit specific post
// Route::put('/posts/{id}/update', [PostController::class, 'update'])
//     ->name('posts.update');

// // Delete specific post
// Route::delete('/posts/{id}/destroy', [PostController::class, 'destroy'])
//     ->name('posts.destroy');
