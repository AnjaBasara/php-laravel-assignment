<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveBookRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{

    public function __construct(private BookService $bookService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $books = $this->bookService->getBooksSorted();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return View
     */
    public function create(): View
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.create', compact('writers', 'publishers'));
    }

    /**
     * Store a newly created book in the database.
     *
     * @param StoreBookRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $this->bookService->createBook($request);

        return redirect()->route('books.index');
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param Book $book
     * @return View
     */
    public function edit(Book $book): View
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'writers', 'publishers'));
    }

    /**
     * Update the specified book in the database.
     *
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $this->bookService->updateBook($request, $book);

        return redirect()->route('books.index');
    }

    /**
     * Reorder the books.
     *
     * @param MoveBookRequest $request
     * @param Book $book
     *
     * @return RedirectResponse
     */
    public function move(MoveBookRequest $request, Book $book): RedirectResponse
    {
        if ($book->stock_amount === 0) {
            return back();
        }

        $this->bookService->moveAndReorderBooks($request, $book);

        return redirect()->route('books.index');
    }
}
