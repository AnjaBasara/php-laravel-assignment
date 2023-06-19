<?php

namespace App\Services\Recommendation\Facades;

use App\Models\Book;
use App\Models\Rating;
use App\Services\Recommendation\Algorithms\Predictor;
use App\Services\Recommendation\Algorithms\Similarity;

class Recommender
{

    public function __construct(
        private Predictor $predictor,
        private Similarity $similarity,
        // ... more complex logic
    ) {
    }

    /**
     * @param Rating $rating
     * @return void
     */
    public function recordData(Rating $rating): void
    {
        // Add this rating to the dataset
    }

    /**
     * @return mixed
     */
    public function buildModel(): mixed
    {
        // Iterate through the dataset and to build the model using the Similarity function

        return null;
    }

    /**
     * @param Rating $rating
     * @return array
     */
    public function predict(Rating $rating): array
    {
        // Predict similar Books using the Predictor

        return [];
    }

    /**
     * @return Book[]
     */
    public function getPredictions(): array
    {
        // Get the predictions to display them to the user.

        return [];
    }
}
