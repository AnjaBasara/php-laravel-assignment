<?php

namespace App\Services;

use App\Http\Requests\MoveBookRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Repositories\BookRepository;

class BookService
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    /**
     * @return Book[]
     */
    public function getBooksSorted(): array
    {
        return $this->bookRepository->getBooksSorted();
    }

    /**
     * Move Book logic.
     * Book should be moved as many places as indicated,
     * while other books need to be reordered.
     *
     * @param MoveBookRequest $request
     * @param Book $movedBook
     * @return void
     */
    public function moveAndReorderBooks(MoveBookRequest $request, Book $movedBook): void
    {
        if ($request->up) {
            $moveCount = (int) $request->up;
        } else {
            $moveCount = -1 * ((int) $request->down);
        }

        if ($moveCount === 0) {
            return;
        }

        $oldPlacement = $movedBook->sort_order;
        $newPlacement = $oldPlacement - $moveCount;

        if ($newPlacement < 1) {
            $newPlacement = 1;
        }

        if ($oldPlacement === $newPlacement) {
            return;
        }

        $arrayBetween = [$newPlacement, $oldPlacement];
        asort($arrayBetween);

        /** @var Book[] $books */
        $books = Book::whereBetween('sort_order', $arrayBetween)->orderBy('sort_order')->get();

        foreach ($books as $book) {
            if ($book->id === $movedBook->id) {
                $book->sort_order = (count($books) > $newPlacement) ? $newPlacement : ($oldPlacement + count($books) - 1);
            } else {
                $book->sort_order += ($moveCount > 0 ? 1 : -1);
            }
            $book->save();
        }
    }

    /**
     * Update Book logic.
     * If the updated Book has stock amount 0, it should not be sorted.
     * Otherwise, it should be ordered last.
     *
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return void
     */
    public function updateBook(UpdateBookRequest $request, Book $book): void
    {
        if ($request->stock_amount !== $book->stock_amount) {
            if ($request->stock_amount == 0) {
                $book->sort_order = -1;
            } else if ($book->stock_amount != 0) {
                $book->sort_order = $this->bookRepository->getNextSortPlacement();
            }
        }

        $this->bookRepository->createOrUpdateBook($request, $book);
    }

    /**
     * Create Book logic.
     * If the new Book has stock amount 0, it should not be sorted.
     * Otherwise, it should be ordered last.
     *
     * @param StoreBookRequest $request
     * @return void
     */
    public function createBook(StoreBookRequest $request): void
    {
        $book = new Book();
        $book->sort_order = $request->stock_amount == 0 ? -1 : $this->bookRepository->getNextSortPlacement();

        $this->bookRepository->createOrUpdateBook($request, $book);
    }
}
