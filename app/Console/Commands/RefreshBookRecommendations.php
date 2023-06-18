<?php

namespace App\Console\Commands;

use App\Services\Recommendation\Facades\Recommender;
use Illuminate\Console\Command;

class RefreshBookRecommendations extends Command
{
    public function __construct(private Recommender $recommender)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book-recommendations:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for refreshing book recommendations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->recommender->buildModel();
        $predictions = $this->recommender->getPredictions();
        // store predictions ...
        return Command::SUCCESS;
    }
}
