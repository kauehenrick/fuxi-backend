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
        return response()->json(Genre::all());
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
        ]);
    }
}
