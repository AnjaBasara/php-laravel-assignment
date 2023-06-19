<?php

namespace App\Services\Recommendation\Strategies;

use App\Models\Book;
use App\Models\Rating;

/**
 * Application can use different recommendation strategies.
 */
interface RecommendationStrategy
{
    public function processCreateRating(Rating $rating);

    public function getRecommendations(): array;
}
