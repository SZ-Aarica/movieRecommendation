<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TmbdService;

class FetchPopularMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-popular-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch popular movies from TMDb API and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Call the TmdbService to fetch and store popular movies
            (new TmbdService)->fetchAndStorePopularMovies();

            $this->info('Popular movies fetched and stored successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to fetch popular movies: ' . $e->getMessage());
        }
    }
}
