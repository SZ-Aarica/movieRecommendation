<?php

namespace App\Models;

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

    public function getMovies()
    {
        return self::all();
    }
}
