<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json([
        'message' => 'Não autenticado.'
    ], 401);
})->name('login');

Route::prefix('api')->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(['auth:web'])
        ->group(function () {
            Route::get('/me', function (Request $request) {
                return response()->json($request->user());
            });

            Route::post('/logout', [UserController::class, 'logout']);

            Route::get('/authors', [AuthorController::class, 'index']);
            Route::post('/authors', [AuthorController::class, 'store']);
            Route::patch('/authors/{author}', [AuthorController::class, 'update']);
            Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);
            Route::patch('/authors/{id}/restore', [AuthorController::class, 'restore']);

            Route::get('/genres', [GenresController::class, 'index']);
            Route::post('/genres', [GenresController::class, 'store']);
            Route::patch('/genres/{genre}', [GenresController::class, 'update']);
            Route::delete('/genres/{genre}', [GenresController::class, 'destroy']);
            Route::patch('/genres/{id}/restore', [GenresController::class, 'restore']);

            Route::get('/books', [BookController::class, 'index']);
            Route::post('/books', [BookController::class, 'store']);
            Route::patch('/books/{book}', [BookController::class, 'update']);
            Route::delete('/books/{book}', [BookController::class, 'destroy']);
            Route::patch('/books/{id}/restore', [BookController::class, 'restore']);
        });
});
