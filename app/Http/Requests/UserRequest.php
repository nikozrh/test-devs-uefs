<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Se a validação falhar, retorna a mensagem de erro.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors()
        ], 422));
    }

    /**
     * Retorna as regras de validação para os dados do usuário.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . ($userId ? $userId : null),
            'password' => 'required|min:8'
        ];
    }

    /**
     * Retorna as mensagens de erro personalizadas.
     *
     * @return array<string, string>
     */
    
    public function messages():array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'email.unique' => 'O email informado já está cadastrado',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter no mínimo :min caracteres',
        ];
    }

}
