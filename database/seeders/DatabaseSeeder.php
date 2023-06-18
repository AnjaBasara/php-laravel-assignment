<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $publishers = Publisher::factory()->count(5)->create();

        $writers = Writer::factory()->count(5)->create();

        for ($i = 1; $i <= 12; $i++) {
            Book::factory()
                ->for($publishers->random())
                ->for($writers->random())
                ->create([
                    'sort_order' => $i,
                ]);
        }

        for ($i = 1; $i <= 8; $i++) {
            Book::factory()
                ->for($publishers->random())
                ->for($writers->random())
                ->create([
                    'stock_amount' => 0,
                ]);
        }
    }
}
