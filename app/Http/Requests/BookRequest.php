<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('books', 'isbn')
                    ->ignore($this->route('book')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'Já existe um livro com este ISBN.',
        ];
    }

    public function attributes(): array
    {
        return [
            'isbn' => 'ISBN',
        ];
    }
}
