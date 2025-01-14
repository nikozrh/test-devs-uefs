<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Gerar o token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $this->respondWithToken($token)]);
    }
    // Logout
    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }
    
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    // Informações do Usuário Autenticado
    public function me()
    {
        return response()->json(Auth::user());
    }

    // Responder com o Token
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => null, // O Laravel Sanctum não define expiração por padrão
        ];
    }    
}