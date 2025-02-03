<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use Illuminate\Support\Facades\Log;

class TmbdService
{

    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = config('services.tmdb.base_url');
    }
    public function makeApiCall($endpoint, $params = [])
    {
        $response = Http::get("{$this->baseUrl}{$endpoint}", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from TMDb API');
        }

        return $response->json();
    }
    public function fetchAndStorePopularMovies()
    {
        try {

            $movies = $this->makeApiCall('/movie/popular', ['api_key' => $this->apiKey]);
            $movies = $movies['results'];

            foreach ($movies as $movie) {
                Movie::updateOrCreate(
                    ['id' => $movie['id']], // Use TMDb's ID as the primary key
                    [
                        'title' => $movie['title'],
                        'overview' => $movie['overview'],
                        'adult' => $movie['adult'],
                        'poster_path' => $movie['poster_path'],
                        'backdrop_path' => $movie['backdrop_path'],
                        'vote_average' => $movie['vote_average'],
                        'vote_count' => $movie['vote_count'],
                        'release_date' => $movie['release_date'],
                        'genres' => $movie['genre_ids']
                    ]
                );
            }


            return true;
        } catch (\Exception $e) {

            Log::error("Error in fetchAndStorePopularMovies: " . $e->getMessage());

            throw $e; // Re-throw the exception so it's caught in the console command

        }
    }
    public function fetchGenreIdAndNames()
    {
        $genres = $this->makeApiCall('/genre/movie/list', ['api_key' => $this->apiKey]);
        $genres = $genres['genres'];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['id' => $genre['id']],
                ['name' => $genre['name']],

            );
        }
    }
}
