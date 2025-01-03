<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo "nome" é obrigatório.',
            'name.string' => 'O campo "nome" deve ser uma string.',
            'name.max' => 'O campo "nome" não pode ter mais que 255 caracteres.',
            'email.required' => 'O campo "email" é obrigatório.',
            'email.email' => 'O campo "email" deve ser um endereço de e-mail válido.',
            'email.unique' => 'Já existe um usuário com esse e-mail.',
            'email.max' => 'O campo "email" não pode ter mais que 255 caracteres.',
            'password.required' => 'O campo "senha" é obrigatório.',
            'password.string' => 'O campo "senha" deve ser uma string.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ];
    }

}
