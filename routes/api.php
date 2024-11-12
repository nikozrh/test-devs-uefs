<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;

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

//Rota para login de usuário, sem a necessidade de autenticação JWT
Route::get('/auth/login', [AuthController::class, 'login']);


// Rota para cadastro de usuário, sem a necessidade de autenticação JWT
Route::post('users', [UserController::class, 'store']);

/**
 * Rotas protegidas por autenticação Jwt
 *
 */

Route::group(['middleware' => ['apiJwt']], function () {
    /**
     * O método apiResource
     * facilita a criação de rotas RESTful
     * ele mapeia automaticamente as ações de um controller 
     * com os métodos HTTP correspondentes (GET, POST, PUT, DELETE)
     */

   // Rota para CRUD de usuários, incluindo as rotas de edição e exclusão, mas não o cadastro
    Route::apiResource('users', UserController::class)->except('store');

    // Rota para CRUD de postagens
    Route::apiResource('posts', PostController::class);

    // Rota para CRUD de tags
    Route::apiResource('tags', TagController::class);

    // Rota para logout do usuário, invalidando o token JWT
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Rota para atualizar o token JWT do usuário
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // Rota para obter as informações do usuário autenticado
    Route::post('me', [AuthController::class, 'me']);
});
