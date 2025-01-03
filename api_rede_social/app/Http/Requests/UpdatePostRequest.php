<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'usuario_id' => 'nullable|exists:usuarios,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.exists' => 'O usuário informado não existe.',
            'title.string' => 'O campo "título" deve ser uma string.',
            'title.max' => 'O campo "título" não pode ter mais que 255 caracteres.',
            'content.string' => 'O campo "conteúdo" deve ser uma string.',
            'tags.array' => 'O campo "tags" deve ser um array.',
            'tags.*.exists' => 'Cada tag informada deve existir.',
        ];
    }

}
