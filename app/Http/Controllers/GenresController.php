<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\GenreRequest;

class GenresController extends Controller
{
    public function store(GenreRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

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
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->update($data);

        return response()->json($genre);
    }

    public function destroy(Genre $genre)
    {
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
