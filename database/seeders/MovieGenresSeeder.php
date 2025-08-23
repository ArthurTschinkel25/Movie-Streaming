<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieGenresSeeder extends Seeder
{
    public function run()
    {
        DB::statement("
            INSERT INTO movie_genres (movie_id, genre_id)
            SELECT m.id, jt.genre_id
            FROM movies m,
            JSON_TABLE(m.genre_ids, '$[*]' COLUMNS (genre_id INT PATH '$')) jt
        ");
    }
}
