<?php

namespace App\Observers;

use App\Jobs\ProcessCreateRating;
use App\Models\Rating;

class RatingObserver
{

    /**
     * Handle the Rating "created" event.
     *
     * @param Rating $rating
     * @return void
     */
    public function created(Rating $rating): void
    {
        // Dispatch ProcessCreateRating job
        dispatch(new ProcessCreateRating($rating));
    }

    /**
     * Handle the Rating "updated" event.
     *
     * @param Rating $rating
     * @return void
     */
    public function updated(Rating $rating)
    {
        //
    }

    /**
     * Handle the Rating "deleted" event.
     *
     * @param Rating $rating
     * @return void
     */
    public function deleted(Rating $rating)
    {
        //
    }

    /**
     * Handle the Rating "restored" event.
     *
     * @param Rating $rating
     * @return void
     */
    public function restored(Rating $rating)
    {
        //
    }

    /**
     * Handle the Rating "force deleted" event.
     *
     * @param Rating $rating
     * @return void
     */
    public function forceDeleted(Rating $rating)
    {
        //
    }
}
