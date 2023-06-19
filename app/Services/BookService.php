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

        $oldSortOrder = $movedBook->sort_order;
        $newSortOrder = $oldSortOrder - $moveCount;

        if ($newSortOrder < 1) {
            $newSortOrder = 1;
        }

        if ($oldSortOrder === $newSortOrder) {
            return;
        }

        $this->reorder($movedBook, $oldSortOrder, $newSortOrder);
    }

    /**
     * Helper function for reordering logic.
     * Iterate through all the books between old and new sort order and move them one place up/down.
     *
     * @param Book $movedBook
     * @param int $oldSortOrder
     * @param int $newSortOrder
     * @return void
     */
    private function reorder(Book $movedBook, int $oldSortOrder, int $newSortOrder): void
    {
        if ($newSortOrder === -1) {
            $arrayBetween = [$oldSortOrder, $this->bookRepository->getNextSortOrder()];
            $sign = -1;
        } else {
            $arrayBetween = [$oldSortOrder, $newSortOrder];
            asort($arrayBetween);
            $sign = ($oldSortOrder - $newSortOrder) > 0 ? 1 : -1;
        }

        /** @var Book[] $books */
        $books = Book::whereBetween('sort_order', $arrayBetween)->orderBy('sort_order')->get();

        if ($newSortOrder !== -1) {
            $newSortOrder = (count($books) > $newSortOrder) ? $newSortOrder : ($oldSortOrder + count($books) - 1);
        }

        foreach ($books as $book) {
            if ($book->id === $movedBook->id) {
                $book->sort_order = $newSortOrder;
            } else {
                $book->sort_order += $sign;
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
                $this->reorder($book, $book->sort_order, -1);
            } else if ($book->stock_amount == 0) {
                $book->sort_order = $this->bookRepository->getNextSortOrder();
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
        $book->sort_order = $request->stock_amount == 0 ? -1 : $this->bookRepository->getNextSortOrder();

        $this->bookRepository->createOrUpdateBook($request, $book);
    }
}
