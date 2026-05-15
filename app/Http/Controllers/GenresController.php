<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\GenreRequest;

class GenresController extends Controller
{
    public function store(GenreRequest $request)
    {
        $data = $request->validated();

        $genre = Genre::create($data);

        return response()->json($genre, 201);
    }

    public function index()
    {
        return response()->json(
            Genre::query()->withTrashed()->get()
        );
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        $data = $request->validated();

        $genre->update($data);

        return response()->json($genre);
    }

    public function destroy(Genre $genre)
        {
            if ($genre->books()->exists()) {
                return response()->json([
                    'message' => 'Não é permitido desativar gêneros associados a livros.'
                ], 422);
            }

        $genre->delete();

        return response()->json([
            'message' => 'Genêro deletado com sucesso.',
            'genre' => $genre->fresh(),
        ]);
    }

    public function restore(int $id)
    {
        $genre = Genre::withTrashed()->findOrFail($id);

        $genre->restore();

        return response()->json([
            'message' => 'Genêro habilitado com sucesso.',
            'genre' => $genre,
        ]);
    }
}
