<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class favourite extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public static function existInFavorite(int $movieId, int $userId): Bool
    { //check if a movie is in the favorite table
        $exists = self::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->exists();
        return $exists;
    }

    public function getUserFavoriteMovies(User $user)
    {
        return self::where("user_id", $user->id)->get();
    }

    public static function mostFavoritedMovies($limit = 1)
    {
        $topMovies = self::select('movie_id', DB::raw('COUNT(movie_id) as total_likes'))
            ->groupBy('movie_id')
            ->orderByDesc('total_likes')
            ->limit($limit)
            ->get();

        return Movie::whereIn('id', $topMovies->pluck('movie_id'))
            ->get()
            ->map(function ($movie) use ($topMovies) {
                $movie->total_likes = $topMovies->firstWhere('movie_id', $movie->id)->total_likes ?? 0;
                return $movie;
            });
    }
}
