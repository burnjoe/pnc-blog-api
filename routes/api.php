<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



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


// Get user followings
Route::get('/users/{id}/following', [UserController::class, 'showFollowing'])
    ->name('users.following');

// Get user followers
Route::get('/users/{id}/followers', [UserController::class, 'showFollowers'])
    ->name('users.followers');

// Follow new writer
Route::post('/follow/{id}', [FollowController::class, 'store'])
    ->name('follow');

// Unfollow specific writer
Route::delete('/unfollow/{id}', [FollowController::class, 'destroy'])
    ->name('unfollow');
    


// Get all posts
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

// Get specific post
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');

// Add new post
Route::post('/posts/store', [PostController::class, 'store'])
    ->name('posts.store');

// Edit specific post
Route::put('/posts/{id}/update', [PostController::class, 'update'])
    ->name('posts.update');

// Delete specific post
Route::delete('/posts/{id}/destroy', [PostController::class, 'destroy'])
    ->name('posts.destroy');


// });

require __DIR__.'/auth.php';