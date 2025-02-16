<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    protected $casts = [
        'genres' => 'array',
    ];

    public function actors()
    {
        return $this->belongsToMany(Actor::class)->withPivot('character');
    }

    public function comment()
    {
        return $this->hasMany(comment::class);
    }

    public static function getRecentMovies($limit)
    {
        return Movie::orderBy('created_at', 'desc') // Order by creation date, newest first
            ->limit($limit)                // Limit the number of results
            ->get();
    }

    public function addData(array $movie, $movieDetail)
    {
        try {

            if (!isset($movie)) {
                Log::error('Missing required movie data: ' . print_r($movie, true));
                return; // Or throw an exception
            }

            Movie::updateOrCreate(
                ['id' => $movie['id']],
                [
                    'title' => $movie['title'],
                    'overview' => $movie['overview'],
                    'adult' => $movie['adult'],
                    'poster_path' => $movie['poster_path'],
                    'backdrop_path' => $movie['backdrop_path'],
                    'vote_average' => $movie['vote_average'],
                    'vote_count' => $movie['vote_count'],
                    'release_date' => $movie['release_date'],
                    'genres' => $movie['genre_ids'],
                    'runtime' => $movieDetail['runtime'] ?? null,
                ]
            );
        } catch (\Exception $e) {

            Log::error("Error in fetchAndStorePopularMovies: " . $e->getMessage());
            // Optionally re-throw the exception or handle it gracefully
        }
    }
}
