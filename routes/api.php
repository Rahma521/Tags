<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify-otp',[UserController::class,'verifyOtp']);

Route::middleware('auth:sanctum')->group( function () {

    Route::resource('tag', TagController::class);
    Route::resource('post', PostController::class);
    Route::get('deletedPosts', [PostController::class, 'viewDeletedPost']);
    Route::get('restore/{id}', [PostController::class, 'restore']);


});
