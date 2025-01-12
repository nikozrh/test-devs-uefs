<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentacaoController; // Importa o controller criado

// Rota principal
Route::get('/', function () {
    return view('welcome');
});

// Rota para a página de documentação
Route::get('/doc', [DocumentacaoController::class, 'index']);
