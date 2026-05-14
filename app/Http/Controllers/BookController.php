<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Validation\Rule;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    public function store(BookRequest $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'localization' => 'nullable|string|max:255',
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('books', 'isbn')->ignore($request->id),
            ],
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function index()
    {
        return response()->json(
            Book::query()->withTrashed()->get()
        );
    }

    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'localization' => 'nullable|string|max:255',
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('books', 'isbn')->ignore($request->id),
            ],
        ]);

        $book->update($data);

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Livro deletado com sucesso.',
            'book' => $book->fresh(),
        ]);
    }

    public function restore(int $id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        $book->restore();

        return response()->json([
            'message' => 'Livro habilitado com sucesso.',
            'book' => $book,
        ]);
    }
}
