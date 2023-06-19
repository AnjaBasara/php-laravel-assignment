<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->randomTitle(),
            'ISBN' => $this->faker->isbn13,
            'publication_year' => $this->faker->year,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'genre' => $this->randomGenre(),
            'subgenre' => $this->randomSubGenre(),
            'sort_order' => -1,
            'stock_amount' => $this->faker->numberBetween(1, 100),
        ];
    }

    private function randomTitle()
    {
        return $this->faker->randomElement([
            'To Kill a Mockingbird',
            'The Great Gatsby',
            'Pride and Prejudice',
            '1984',
            'The Catcher in the Rye',
            'Moby-Dick',
            'The Lord of the Rings',
            'Harry Potter and the Sorcerer\'s Stone',
            'The Chronicles of Narnia',
            'Brave New World',
            'The Hobbit',
            'The Adventures of Huckleberry Finn',
            'Jane Eyre',
            'The Grapes of Wrath',
            'The Odyssey',
            'A Tale of Two Cities',
            'Animal Farm',
            'The Scarlet Letter',
            'The Count of Monte Cristo',
            'Wuthering Heights',
            'The Picture of Dorian Gray',
            'Lord of the Flies',
            'Gone with the Wind',
            'Frankenstein',
            'Don Quixote',
            'War and Peace',
            'Les Misérables',
            'Crime and Punishment',
            'Alice\'s Adventures in Wonderland',
            'The Alchemist',
            'The Kite Runner',
        ]);
    }

    private function randomGenre()
    {
        return $this->faker->randomElement([
            'Fiction',
            'Non-Fiction',
            'Mystery',
            'Romance',
            'Science Fiction',
            'Fantasy',
            'Thriller',
            'Historical',
            'Biography',
            'Horror',
        ]);
    }

    private function randomSubGenre()
    {
        return $this->faker->randomElement([
            'Contemporary',
            'Historical',
            'Young Adult',
            'Dystopian',
            'Crime',
            'Classic',
            'Adventure',
            'Science Fiction',
            'Fantasy',
            'Romantic Comedy',
        ]);
    }
}
