<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Movie;

class movieController extends Controller
{
    public function index()
    {

        $movies = Movie::simplePaginate(6);

        return view(
            'movies.index',
            [
                'movies' => $movies
            ]
        );
        //https://api.themoviedb.org/3/movie/popular?api_key=7429882064bd146f8c3147d6ec343807
        //https://image.tmdb.org/t/p/w400/kW9LmvYHAaS9iA0tHmZVq8hQYoq.jpgs 
        //send data to the view
    }
    public function search() {}

    public function suggest()
    {
        return view('movies.taste', ['datas' => null]);
    }

    public function show(Movie $movie)
    {
        return view('movies.show', ['movies' => $movie]);
    }
}
