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
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books', 'title')
                    ->ignore($this->route('book')),
            ],

            'author_id' => [
                'required',
                Rule::exists('authors', 'id')->whereNull('deleted_at'),
            ],

            'genre_id' => [
                'required',
                Rule::exists('genres', 'id')->whereNull('deleted_at'),
            ],

            'published_year' => [
                'nullable',
                'integer',
                'min:1000',
                'max:' . date('Y'),
            ],

            'amount' => [
                'required',
                'integer',
                'min:1',
            ],

            'localization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:13',
                Rule::unique('books', 'isbn')
                    ->ignore($this->route('book')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Já existe um livro com este título.',
            'isbn.unique' => 'Já existe um livro com este ISBN.',
            'author_id.exists' => 'Selecione um autor ativo.',
            'genre_id.exists' => 'Selecione um gênero ativo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'título',
            'isbn' => 'ISBN',
        ];
    }
}
