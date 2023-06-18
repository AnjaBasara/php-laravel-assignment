<?php

namespace App\Repositories;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;

class BookRepository
{

    /**
     * @param StoreBookRequest|UpdateBookRequest $request
     * @param Book $book
     * @return void
     */
    public function createOrUpdateBook(StoreBookRequest|UpdateBookRequest $request, Book $book): void
    {
        $book->title = $request->title;
        $book->ISBN = $request->ISBN;
        $book->publication_year = $request->publication_year;
        $book->price = $request->price;
        $book->genre = $request->genre;
        $book->subgenre = $request->subgenre;
        $book->stock_amount = $request->stock_amount;
        $book->writer_id = $request->writer_id;
        $book->publisher_id = $request->publisher_id;
        $book->save();
    }

    /**
     * Get Books sorted by sort_order, where Books with sort_order -1 are placed at the bottom.
     *
     * @return Book[]
     */
    public function getBooksSorted(): array
    {
        return Book::all()->sortBy(function (Book $book) {
            return $book->sort_order > 0 ? $book->sort_order : PHP_INT_MAX;
        })->values()->all();
    }

    /**
     * Get next sort_order.
     *
     * @return int
     */
    public function getNextSortPlacement(): int
    {
        /** @var Book $lastBook */
        $lastBook = Book::where('sort_order', '>', 0)->orderBy('sort_order')->last();

        return $lastBook->sort_order + 1;
    }
}
