<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'runtime',
        'popularity',
        'imdb_id',
        'origin_country',
        'adult',
        'budget',
        'genres',
    ];
    protected $casts = [
        'genres' => 'array',
    ];

    public function getGenresAttribute($value)
    {
        return json_decode($value, true);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
