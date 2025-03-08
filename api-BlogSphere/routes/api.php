<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// GET /api/users → Lista todos os usuários
// GET /api/users/{id} → Exibe um usuário específico
// POST /api/users → Cria um usuário
// PUT /api/users/{id} → Atualiza um usuário
// DELETE /api/users/{id} → Deleta um usuário
Route::apiResource('users', UserController::class);





