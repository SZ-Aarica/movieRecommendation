<?php

namespace App\Http\Controllers;

use App\Models\genre;
use App\Services\TmbdService;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Movie;

class movieController extends Controller
{
    public function index(Request $request)
    {

        $genre = new genre();
        //dd($genre[0]);
        // Check if a search query is provided
        //the form input name id movie
        $searchQuery = $request->input('movie');

        if ($searchQuery) {
            // Validate the search input
            $validated = $request->validate([
                'movie' => ['required', 'min:3'],
            ]);

            // Search for the movie in the database
            $movies = Movie::where('title', 'like', '%' . $validated['movie'] . '%')->simplePaginate(6);

            // If no results are found in the database, fetch from the external API
            if ($movies->isEmpty()) {
                $apiKey = '7429882064bd146f8c3147d6ec343807';
                $client = new Client();
                $url = "https://api.themoviedb.org/3/search/movie?query={$validated['movie']}&include_adult=false&language=en-US&page=1&api_key={$apiKey}";

                try {
                    $response = $client->get($url);
                    $data = json_decode($response->getBody(), true);

                    if (isset($data['results'])) {
                        foreach ($data['results'] as $movieData) {
                            Movie::updateOrCreate(
                                ['id' => $movieData['id']],
                                [
                                    'title' => $movieData['title'],
                                    'overview' => $movieData['overview'],
                                    'adult' => $movieData['adult'],
                                    'poster_path' => $movieData['poster_path'],
                                    'backdrop_path' => $movieData['backdrop_path'],
                                    'vote_average' => $movieData['vote_average'],
                                    'vote_count' => $movieData['vote_count'],
                                    'release_date' => $movieData['release_date'],
                                    'genres' => json_encode($movieData['genre_ids']),
                                ]
                            );
                        }
                    }

                    // Re-fetch the movies after updating the database
                    $movies = Movie::where('title', 'like', '%' . $validated['movie'] . '%')->simplePaginate(6);
                } catch (\Exception $e) {
                    // Handle API errors gracefully
                    return back()->withErrors(['movie' => 'An error occurred while fetching data from the API.']);
                }
            }
        } else {
            // Default behavior: Show all movies
            $movies = Movie::simplePaginate(6);
        }

        // Pass the movies to the view
        return view('movies.index', [
            'movies' => $movies,
            'searchQuery' => $searchQuery, // Pass the search query to the view
            'genre' => $genre,
        ]);
    }


    public function suggest()
    {

        return view('movies.taste', ['datas' => null]);
    }
    public function similar()
    {
        $validatedAtr = request()->validate([
            'movie' => ['required', 'min:3'],
        ]);
        $apiKey = '1038147-moviesug-6E204011';
        $client = new Client();
        $Url = "https://tastedive.com/api/similar?q={$validatedAtr['movie']}&type=movie&k=$apiKey";

        $response = $client->get($Url);
        $data = json_decode($response->getBody(), true);
        //dd($data['similar']['results']);
        return view('movies.taste', ['datas' => $data['similar']['results']]);
    }

    public function show(Movie $movie)
    {
        $genre = new genre();
        return view('movies.show', ['movies' => $movie, 'genres' => $genre]);
    }
}
