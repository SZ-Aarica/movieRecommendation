<?php

namespace App\Services;

use App\Models\Actor;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
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

        $params['api_key'] = $this->apiKey;
        $response = Http::get("{$this->baseUrl}{$endpoint}", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from TMDb API');
        }

        return $response->json();
    }
    public function addActors(int $id)
    {
        $actor =  $this->makeApiCall("/person/{$id}");
        if (isset($actor['id'], $actor['name'])) {
            // Call addData to insert or update the actor in the database
            Actor::addData($actor);
        } else {
            // Handle cases where the API does not return valid actor data
            throw new \Exception("Invalid actor data received from TMDb for ID: {$id}");
        }
    }
    public function FetchCredits($movies)
    {
        //$movies = Movie::getRecentMovies(15);
        //dd($movies);
        // foreach ($movies as $movie) {
        $credits = $this->makeApiCall(
            "/movie/{$movies['id']}/credits?language=en-US"
        );
        //Log::debug('Credits for movie ' . $movies['id'], $credits);
        //dd($credits['cast']);
        foreach (collect($credits['cast'])->take(10) as $castMember) {
            // Check for required fields from the API response
            if (!isset($castMember['id'])) {
                continue;
            }
            $actorExists = Actor::where('id', $castMember['id'])->exists();


            if (!$actorExists) {
                // If the actor doesn't exist, fetch and add them to the database
                $this->addActors($castMember['id']);
            }
            try {
                DB::table('actor_movie')->updateOrInsert(
                    [
                        'movie_id' => $movies['id'],
                        'actor_id' => $castMember['id'],
                    ],
                    [
                        'character' => $castMember['character'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } catch (\Exception $e) {
                Log::error("Error in adding data: " . $e->getMessage());
            }
        }
        // }
    }
    public function fetchAndStorePopularMovies()
    {
        $ModelMovie = new Movie();
        try {
            $movies = $this->makeApiCall('/movie/popular', ['api_key' => $this->apiKey]);
            $movies = $movies['results'];
            foreach ($movies as $movie) {
                $movieDetail = $this->makeApiCall("/movie/{$movie['id']}", ['api_key' => $this->apiKey]);
                $ModelMovie->addData($movie, $movieDetail);
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
