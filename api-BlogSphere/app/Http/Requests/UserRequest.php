<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo "Nome" é obrigatório.',
            'name.string' => 'O campo "Nome" deve ser uma string.',
            'name.max' => 'O campo "Nome" não pode ter mais que 255 caracteres.',
            'email.required' => 'O campo "E-mail" é obrigatório.',
            'email.email' => 'O campo "E-mail" deve ser um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'password.required' => 'O campo "Senha" é obrigatório.',
            'password.string' => 'O campo "Senha" deve ser uma string.',
            'password.min' => 'O campo "Senha" deve ter no mínimo 8 caracteres.'
        ];
    }
}




 