<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserWebController extends Controller
{
    

    // Método para processar o registro do usuário na página web
    public function store(Request $request)
    {
        // Validando os dados do formulário
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tratar erro de validação dos dados de entrada.
        if ($validator->fails()) {            
            return redirect()->back()->withErrors($validator->errors()->all());
        }

        try {
            // Criando o novo usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),  
            ]);

            $credentials = $request->only('email', 'password');

            //Logando após cadastro
            if (Auth::attempt($credentials)) {
                session(['token' => auth('api')->attempt($credentials)]);
                return redirect()->guest('/postagens')->cookie('token', session('token'), 60, null, null, false, true);
            }
            
        } catch (\Exception $e) {
            // Caso haja algum erro no processo de criação (como erro de DB)
            return redirect()->back()->withErrors(['message' => 'Ocorreu um erro ao tentar cadastrar o usuário. Tente novamente.']);
        }
    }
}
