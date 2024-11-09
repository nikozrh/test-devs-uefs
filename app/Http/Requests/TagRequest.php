<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'post_id' => 'required|integer'
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
            'post_id.required' => 'A id do post é obrigatório',
            'name.required' => 'O campo nome é obrigatório',
            'name.min' => 'O nome da tag deve ter no mínimo :min caracteres',
        ];
    }
}
