<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        
        return [

            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'tags' => 'filled|array|min:1', // Deve estar preenchido e conter pelo menos 1 item
            'tags.*' => 'exists:tags,id',    // Cada tag precisa existir na tabela tags
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo "usuário" é obrigatório.',
            'user_id.exists' => 'O usuário informado não existe.',
            'title.required' => 'O campo "título" é obrigatório.',
            'title.string' => 'O campo "título" deve ser uma string.',
            'title.max' => 'O campo "título" não pode ter mais que 255 caracteres.',
            'content.required' => 'O campo "conteúdo" é obrigatório.',
            'content.string' => 'O campo "conteúdo" deve ser uma string.',
            'tags.array' => 'O campo "tags" deve ser um array.',
            'tags.*.exists' => 'Cada tag informada deve existir.',
        ];
    }
}
