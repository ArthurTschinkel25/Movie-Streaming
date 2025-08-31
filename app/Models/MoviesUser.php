<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoviesUser extends Model
{
    protected $table = 'movies_user';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'movie_id',
    ];
}
