<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{

    protected $fillable = ['id', 'name', 'biography', 'birthday', 'deathday'];


    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('character');
    }

    public function IdToName(int $id)
    {
        return self::where('id', $id)->first()->name;
    }

    public static function addData($actor)
    {
        self::updateOrCreate(
            ['id' => $actor['id']],
            [
                'name' => $actor['name'],
                'biography' => $actor['biography'],
                'birthday' => $actor['birthday'],
                'deathday' => $actor['deathday'] ?? null,
            ]

        );
    }
}
