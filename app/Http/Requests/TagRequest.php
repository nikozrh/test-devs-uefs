<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Manipular falha de validação e retornar uma resposta JSON com os erros de validação.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator O objeto de validação que contém os erros de validação.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors(),
        ], 422));
    }

    /**
     * Retorna as regras de validação para os dados da tag.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // Recuperar o id da tag enviado na URL
        $tagId = $this->route('tag');

        return [
            'name' => 'required'
        ];
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Por favor, informe o nome da tag!'
        ];
    }
}
