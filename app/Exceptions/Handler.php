<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Uma lista dos tipos de exceção que são relatadas.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        NotFoundHttpException::class,
        // Adicione outras exceções que você não deseja relatar aqui
    ];

    /**
     * Registra o tratamento de exceções.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Exception $e) {
            //
        });

        // Tratar exceções de autenticação
        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Necessário realizar login'], 401);
            }
        });

        // Tratar outras exceções se necessário
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Rota não encontrada'], 404);
            }
        });
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }
    
        return response()->json(['error' => 'Route [login] not defined'], 404);
    }    
}
