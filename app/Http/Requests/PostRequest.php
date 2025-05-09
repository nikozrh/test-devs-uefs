<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3|max:5000',
            'user_id' => 'required|integer|exists:users,id',
            'tags'    => 'sometimes|array',
            'tags.*'  => 'distinct|integer|exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required',
            'content.required' => 'The content is required',
            'user_id.required' => 'The author is required',
            'user_id.exists' => 'The selected author is invalid',
            'tags.array' => 'Tags must be an array',
            'tags.*.exists' => 'One or more selected tags are invalid',
        ];
    }
}
