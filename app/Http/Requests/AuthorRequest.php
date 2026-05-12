<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('authors', 'name')
                    ->ignore($this->route('author')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Já existe um autor(a) com esse nome.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
        ];
    }
}
