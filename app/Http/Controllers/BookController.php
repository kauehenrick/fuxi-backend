<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'localization' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function index()
    {
        return response()->json(Book::all());
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'localization' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
        ]);

        $book->update($data);

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Livro deletado com sucesso.',
        ]);
    }
}
