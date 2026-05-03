<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')
    ->middleware([])
    ->group(function () {
        Route::get('/authors', [AuthorController::class, 'index']);
        Route::post('/authors', [AuthorController::class, 'store']);
        Route::patch('/authors/{author}', [AuthorController::class, 'update']);
        Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

        Route::get('/genres', [GenresController::class, 'index']);
        Route::post('/genres', [GenresController::class, 'store']);
        Route::patch('/genres/{genre}', [GenresController::class, 'update']);
        Route::delete('/genres/{genre}', [GenresController::class, 'destroy']);

        Route::get('/books', [BookController::class, 'index']);
        Route::post('/books', [BookController::class, 'store']);
        Route::patch('/books/{book}', [BookController::class, 'update']);
    });
