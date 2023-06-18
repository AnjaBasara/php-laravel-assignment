<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\WriterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers.index');
Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
Route::post('/publishers', [PublisherController::class, 'store'])->name('publishers.store');
Route::get('/publishers/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
Route::put('/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');

Route::get('/writers', [WriterController::class, 'index'])->name('writers.index');
Route::get('/writers/create', [WriterController::class, 'create'])->name('writers.create');
Route::post('/writers', [WriterController::class, 'store'])->name('writers.store');
Route::get('/writers/{writer}/edit', [WriterController::class, 'edit'])->name('writers.edit');
Route::put('/writers/{writer}', [WriterController::class, 'update'])->name('writers.update');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::post('/books/{book}/move', [BookController::class, 'move'])->name('books.move');
