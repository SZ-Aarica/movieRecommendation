<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class TmbdService
{
    public function fetchAndStorePopularMovies()
    {
        $apiKey = config('services.tmdb.api_key');
        $baseUrl = config('services.tmdb.base_url');

        $response = Http::get("{$baseUrl}/movie/popular", [
            'api_key' => $apiKey,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from TMDb API');
        }

        $movies = $response->json()['results'];

        foreach ($movies as $movie) {
            Movie::updateOrCreate(
                ['id' => $movie['id']], // Use TMDb's ID as the primary key
                [
                    'title' => $movie['title'],
                    'overview' => $movie['overview'],
                    'poster_path' => $movie['poster_path'],
                    'backdrop_path' => $movie['backdrop_path'],
                    'vote_average' => $movie['vote_average'],
                    'vote_count' => $movie['vote_count'],
                    'release_date' => $movie['release_date'],
                ]
            );
        }

        return true;
    }
}
