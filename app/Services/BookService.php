<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    /**
     * @param Book $movedBook
     * @param int $moveCount how many places the Book needs to be moved
     * @return void
     */
    public function reorderBooks(Book $movedBook, int $moveCount): void
    {
        if ($moveCount === 0) {
            return;
        }

        $oldPlacement = $movedBook->sort_order;
        $newPlacement = $oldPlacement - $moveCount;

        $arrayBetween = [$newPlacement, $oldPlacement];
        asort($arrayBetween);

        /** @var Book[] $books */
        $books = Book::whereBetween('sort_order', $arrayBetween)->orderBy('sort_order')->get();

        foreach ($books as $book) {
            if ($book->id === $movedBook->id) {
                $book->sort_order = $newPlacement;
            } else {
                $book->sort_order += ($moveCount > 0 ? 1 : -1);
            }
            $book->save();
        }
    }
}
