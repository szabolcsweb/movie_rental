<?php

require_once __DIR__ . '/../models/Movie.php';

use Illuminate\Database\Eloquent\Model;

class MovieRental extends Model
{
    protected $table = 'rentals';
    protected $fillable = ['movie_id', 'customer_name', 'rental_date', 'return_date'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }
}
