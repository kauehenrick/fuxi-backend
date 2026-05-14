<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;

class AuthorController extends Controller
{
    public function store(AuthorRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::create($data);

        return response()->json($author, 201);
    }

    public function index()
    {
        return response()->json(
            Author::query()->withTrashed()->get()
        );
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($data);

        return response()->json($author);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message' => 'Autor deletado com sucesso.',
            'author' => $author->fresh(),
        ]);
    }
    
    public function restore(int $id)
    {
        $author = Author::withTrashed()->findOrFail($id);

        $author->restore();

        return response()->json([
            'message' => 'Autor(a) habilitado com sucesso.',
            'author' => $author,
        ]);
    }
}
