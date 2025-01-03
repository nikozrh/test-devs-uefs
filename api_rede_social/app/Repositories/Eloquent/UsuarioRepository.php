<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function getAllUsuarios()
    {
        try {
            $usuarios = Usuario::all();
            return $usuarios;
            /* return response()->json([
                'message' => 'Lista de usuários recuperada com sucesso',
                'usuarios' => $usuarios,
            ], 200); */ // Código HTTP 200
    
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao recuperar a lista de usuários',
                'details' => $e->getMessage(),
            ], 500); // Código HTTP 500
        }
    }

    public function getUsuarioById(int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id); // Lança 404 se o usuário não for encontrado
            return $usuario;
            /* return response()->json([
                'message' => 'Usuário encontrado com sucesso',
                'usuario' => $usuario,
            ], 200); */ // Código HTTP 200
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404); // Código HTTP 404
        }
    }

    public function createUsuario(array $data)
    {
        try {
            $usuario = Usuario::create($data);
            
            return $usuario;
            /* return response()->json([
                'message' => 'Usuário criado com sucesso',
                'usuario' => $usuario,
            ], 201); */ // Código HTTP 201
    
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500); // Código HTTP 500
        }
    }

    public function updateUsuario(int $id, array $data)
    {
        try {
            $usuario = Usuario::findOrFail($id); // Lança 404 se o usuário não for encontrado
            $usuario->update($data);
            return $usuario; // Código HTTP 200
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404); // Código HTTP 404
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500); // Código HTTP 500 para outros erros
        }
    }

    public function deleteUsuario(int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id); // Lança 404 se o usuário não for encontrado
            $usuario->delete();
    
            return response()->json(['message' => 'Usuário deletado com sucesso'], 204); // Código HTTP 204
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404); // Código HTTP 404
        }
    }
}
