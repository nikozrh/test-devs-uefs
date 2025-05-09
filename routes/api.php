<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;

// Define API routes for user-related operations
Route::apiResource('users', UserController::class);

// Define route for user creation
Route::post('users', [UserController::class, 'store']);

// Define API routes for post-related operations
Route::apiResource('posts', PostController::class);

// Define API routes for tag-related operations
Route::apiResource('tags', TagController::class);
