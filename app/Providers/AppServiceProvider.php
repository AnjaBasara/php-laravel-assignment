<?php

namespace App\Providers;

use App\Models\Rating;
use App\Observers\RatingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Rating::observe(RatingObserver::class);
    }
}
