<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Middleware aplicado a todas as rotas da API
Route::middleware('auth:sanctum')->group(function () {
    // ROTAS PARA USUÁRIOS
    Route::get('/users', [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users
    Route::get('/users/{user}', [UserController::class, 'show']); // GET - http://127.0.0.1:8000/api/users/1
    Route::post('/users', [UserController::class, 'store']); // POST - http://127.0.0.1:8000/api/users
    Route::put('/users/{user}', [UserController::class, 'update']); // PUT - http://127.0.0.1:8000/api/users/1
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/users/1

    // ROTAS PARA POSTS
    Route::get('/posts', [PostController::class, 'index']); // GET - http://127.0.0.1:8000/api/posts
    Route::get('/posts/{post}', [PostController::class, 'show']); // GET - http://127.0.0.1:8000/api/posts/1
    Route::post('/posts', [PostController::class, 'store']); // POST - http://127.0.0.1:8000/api/posts
    Route::put('/posts/{post}', [PostController::class, 'update']); // PUT - http://127.0.0.1:8000/api/posts/1
    Route::delete('/posts/{post}', [PostController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/posts/1

    // ROTAS PARA TAGS
    Route::get('/tags', [TagController::class, 'index']); // GET - http://127.0.0.1:8000/api/tags
    Route::get('/tags/{tag}', [TagController::class, 'show']); // GET - http://127.0.0.1:8000/api/tags/1
    Route::post('/tags', [TagController::class, 'store']); // POST - http://127.0.0.1:8000/api/tags
    Route::put('/tags/{tag}', [TagController::class, 'update']); // PUT - http://127.0.0.1:8000/api/tags/1
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/tags/1
});