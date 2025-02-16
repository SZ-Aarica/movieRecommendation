<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

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
}
