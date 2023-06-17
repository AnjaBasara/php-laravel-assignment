<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{

    public function __construct(public BookService $bookService)
    {
    }

    public function index()
    {
        $books = Book::all()->sortBy(function (Book $book) {
            return $book->sort_order > 0 ? $book->sort_order : PHP_INT_MAX;
        })->values()->all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return View
     */
    public function create()
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.create', compact('writers', 'publishers'));
    }

    /**
     * Store a newly created book in the database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'subgenre' => 'required|string|max:255',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        Book::create([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'sort_order' => -1,
            'stock_amount' => $request->input('stock_amount'),
            'subgenre' => $request->input('subgenre'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param Book $book
     * @return View
     */
    public function edit(Book $book)
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'writers', 'publishers'));
    }

    /**
     * Update the specified book in the database.
     *
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'subgenre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $book->update([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'subgenre' => $request->input('subgenre'),
            'sort_order' => -1,
            'stock_amount' => $request->input('stock_amount'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Reorder the books.
     *
     * @param Request $request
     * @param Book $book
     *
     * @return RedirectResponse
     */
    public function reorder(Request $request, Book $book): RedirectResponse
    {
        if ($book->stock_amount === 0) {
            return back();
        }

        if ($request->input('up') && $request->input('down')) {
            return back();
        }

        $request->validate([
            'up' => 'nullable|integer|min:0',
            'down' => 'nullable|integer|min:0',
        ]);

        if ($request->input('up')) {
            $moveCount = (int) $request->input('up');
        } else {
            $moveCount = -1 * ((int) $request->input('down'));
        }

        $this->bookService->reorderBooks($book, $moveCount);

        return redirect()->route('books.index');
    }
}
