<?php

namespace App\Services\Recommendation\Strategies;

use App\Models\Book;
use App\Models\Rating;

/**
 * This strategy is calling a third-party API to process the ratings.
 */
class ContentBasedFilteringService implements RecommendationStrategy
{
    // private ThirdPartyClientForContentBasedFiltering $client;

    public function __construct()
    {
        // Initialize the client using env credentials
    }

    /**
     * @param Rating $rating
     * @return void
     */
    public function processCreateRating(Rating $rating)
    {
        // $this->client->postRating( ... )
    }

    /**
     * @return Book[]
     */
    public function getRecommendations(): array
    {
        // get recommendations from the client

        return [];
    }
}
