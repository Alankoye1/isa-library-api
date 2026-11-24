<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';
        $book = $this->route('book');

        return [
            'title' => [$required, 'string', 'max:255'],
            'author' => [$required, 'string', 'max:255'],
            'isbn' => [$required, 'string', Rule::unique('books', 'isbn')->ignore($book)],
            'year' => ['nullable', 'integer', 'between:1000,2100'],
        ];
    }
}
