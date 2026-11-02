<?php

use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\FriendslistapisController;
use App\Http\Controllers\Api\PostapisController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// users api
Route::get('userslist', [AuthUserController::class, 'index']);
Route::post('signup', [AuthUserController::class, 'signup']);
Route::post('login', [AuthUserController::class, 'login']);
Route::post('logout', [AuthUserController::class, 'logout'])->middleware('auth:sanctum');

// All post route after login validation 
// Route::middleware('auth:sanctum')->group(function () {
//     // Route::get('posts', [PostapisController::class, 'index']);
//     // Route::post('posts', [PostapisController::class, 'store']);
//     // Route::put('posts/{post}', [PostapisController::class, 'update']);
//     // Route::delete('posts/{post}', [PostapisController::class, 'destroy'])

//     Route::post('logout', [AuthUserController::class, 'logout']);
//     Route::apiResource('posts', PostapisController::class);
// });

Route::apiResource('posts', PostapisController::class);
Route::apiResource('friends', FriendslistapisController::class);
