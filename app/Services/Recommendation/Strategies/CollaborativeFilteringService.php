<?php

namespace App\Services\Recommendation\Strategies;

use App\Models\Book;
use App\Models\Rating;
use App\Services\Recommendation\Facades\Recommender;

/**
 * This strategy is using the internal recommendation algorithm hidden behind the Recommender facade.
 */
class CollaborativeFilteringService implements RecommendationStrategy
{
    public function __construct(private Recommender $recommender)
    {
    }

    /**
     * @param Rating $rating
     * @return void
     */
    public function processCreateRating(Rating $rating): void
    {
        $this->recommender->recordData($rating);
    }

    /**
     * @return Book[]
     */
    public function getRecommendations(): array
    {
        // get recommendations from the Facade
        return $this->recommender->getPredictions();
    }
}
