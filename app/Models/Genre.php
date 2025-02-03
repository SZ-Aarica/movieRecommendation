<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    protected $guarded = [];

    public static function getAllGenres()
    {
        return self::all();
    }

    public function idToNameGenre(array $array)
    {
        $namedGenres = [];
        $allGenres = $this->getAllGenres();

        foreach ($array as $genreId) {
            foreach ($allGenres as $genre) {
                if ($genre['id'] == $genreId) {
                    $namedGenres[] = $genre['name'];
                    break; // Exit the inner loop once the genre is found
                }
            }
        }
        return $namedGenres;
    }
}
