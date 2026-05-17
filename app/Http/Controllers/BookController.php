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
        $book = Book::create($request->validated());

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
        $book->update($request->validated());

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
