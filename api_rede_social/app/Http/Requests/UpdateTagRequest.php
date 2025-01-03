<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255|unique:tags,name,' . $this->route('tag')->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo "nome" deve ser uma string.',
            'name.max' => 'O campo "nome" não pode ter mais que 255 caracteres.',
            'name.unique' => 'Já existe uma tag com esse nome.',
        ];
    }
}
