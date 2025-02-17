<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\favourite;
use App\Models\genre;
use App\Services\TmbdService;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Pail\ValueObjects\Origin\Console;

class movieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmbdService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $favorite = new favourite();
        $favoriteMovieIds = $favorite->getUserFavoriteMovies($user)->pluck('movie_id');
        //$topMovies = $favorite->mostFavoritedMovies();

        $favoriteMovies = Movie::whereIn('id', $favoriteMovieIds)->simplePaginate(2);

        return view('dashboard', compact('favoriteMovies'));
    }
    public function index(Request $request)
    {

        $searchQuery = $request->input('movie');
        $ModelMovie = new Movie();
        $favorite = new favourite();
        $topMovies = $favorite->mostFavoritedMovies();

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
                        $slicedMovies = array_slice($data['results'], 0, 2);
                        foreach ($slicedMovies as $movieData) {
                            //$movieData = $data['results'][0];
                            $movieDetail = $this->tmdbService->makeApiCall("/movie/{$movieData['id']}");
                            $ModelMovie->addData($movieData, $movieDetail);
                            $this->tmdbService->FetchCredits($movieData);
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
            $movies = Movie::orderBy('release_date', 'desc')->Paginate(6);
        }
        // Pass the movies to the view
        return view('movies.index', [
            'movies' => $movies,
            'searchQuery' => $searchQuery, // Pass the search query to the view
            'topMovies' => $topMovies,

        ]);
    }
    public function suggest()
    {

        return view('movies.taste', ['datas' => null]);
    }
    public function similar()
    {
        $validatedAtr = request()->validate([
            'movie' => ['required', 'min:2'],
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

        $movie->load('actors');
        $comments = new comment();
        $genre = new genre();
        $user = new User();
        return view(
            'movies.show',
            [
                'movies' => $movie,
                'genres' => $genre,
                'comments' => $comments,
                'user' => $user
            ]
        );
    }
    public function addComment(Request $request)
    {

        $validatedData = $request->validate([
            'comment' => ['required', 'min:10'],
            'user_id' => ['required', 'exists:users,id'],
            'movie_id' => ['required', 'exists:movies,id'],
        ]);
        comment::create($validatedData);
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function addFavorite(Request $request)
    {

        // Validate incoming request
        $request->validate([
            'user_id' => 'required|integer',
            'movie_id' => 'required|integer',
        ]);

        $userId = $request->input('user_id');
        $movieId = $request->input('movie_id');

        /* return response()->json([
            'user_id' => $userId,
            'movie_id' => $movieId,
        ]);*/
        $exists = favourite::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Movie is already in your favorites.'], 200);
        }
        favourite::create([
            'user_id' => $userId,
            'movie_id' => $movieId,
        ]);

        return response()->json(['message' => 'Movie added to your favorites.'], 201);
    }
    //reviews
    public function displayAllReviews(Movie $movie)
    {
        $comments = new comment();
        $user = new User();
        return view('movies.comments', ['comments' => $comments, 'movie' => $movie, 'user' => $user]);
    }

    /**
     * Remove a movie from the user's favorites.
     */
    public function removeFavorite(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'user_id' => 'required|integer',
            'movie_id' => 'required|integer',
        ]);

        $userId = $request->input('user_id');
        $movieId = $request->input('movie_id');

        /*return response()->json([
            'user_id' => $userId,
            'movie_id' => $movieId,
        ]);*/

        $favorite = favourite::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->first();

        $favorite->delete(); //Delete the favorite entry

        return response()->json(['message' => 'Movie removed from your favorites.'], 200);
    }
}
