<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
        return [
            'title' => 'required|string|min:2',
            'content' => 'required|string|min:10',
            'user_id' => 'required|integer'
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
            'user_id.required' => 'A id do usuário é obrigatório',
            'title.required' => 'O campo titulo é obrigatório',
            'title.min' => 'O titulo deve ter no mínimo :min caracteres',
            'content.required' => 'O campo conteudo é obrigatório',
            'content.min' => 'O conteudo deve ter no mínimo :min caracteres',
        ];
    }
}
