<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/MovieRental.php';
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    protected $fillable = ['title', 'genre', 'release_year', 'rating'];

    public function rental()
    {
        return $this->hasOne(MovieRental::class, 'movie_id');
    }
}
