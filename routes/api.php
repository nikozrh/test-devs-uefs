<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;


// ROTAS PARA USUÁRIOS
    // Lista geral de usuários
    Route::get('/users', [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users

    // Visualizar usuários
    Route::get('/users/{user}', [UserController::class, 'show']); // GET - http://127.0.0.1:8000/api/users/1

    // Inserir usuários
    Route::post('/users', [UserController::class, 'store']); // POST - http://127.0.0.1:8000/api/users

    // Update usuários
    Route::put('/users/{user}', [UserController::class, 'update']); // PUT - http://127.0.0.1:8000/api/users/1

    // Delete usuários
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/users/1

//ROTAS PARA POSTS
    Route::get('/posts', [PostController::class, 'index']); // GET - http://127.0.0.1:8000/api/posts

    // Visualizar posts
    Route::get('/posts/{post}', [PostController::class, 'show']); // GET - http://127.0.0.1:8000/api/posts/1

    // Inserir posts
    Route::post('/posts', [PostController::class, 'store']); // POST - http://127.0.0.1:8000/api/posts

    // Update posts
    Route::put('/posts/{post}', [PostController::class, 'update']); // PUT - http://127.0.0.1:8000/api/posts/1

    // Delete posts
    Route::delete('/posts/{post}', [PostController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/posts/1

// ROTAS PARA TAGS
    Route::get('/tags', [TagController::class, 'index']); // GET - http://127.0.0.1:8000/api/tags

    // Visualizar tags
    Route::get('/tags/{tag}', [TagController::class, 'show']); // GET - http://127.0.0.1:8000/api/tags/1

    // Inserir tags
    Route::post('/tags', [TagController::class, 'store']); // POST - http://127.0.0.1:8000/api/tags

    // Update tags
    Route::put('/tags/{tag}', [TagController::class, 'update']); // PUT - http://127.0.0.1:8000/api/tags/1

    // Delete tags
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/tags/1