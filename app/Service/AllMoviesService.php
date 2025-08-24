<?php

namespace App\Service;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class AllMoviesService
{
    public function returnMovies()
    {
        $movies = [];
        $rows = DB::table('movies')
            ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
            ->join('genres', 'movie_genres.genre_id', '=', 'genres.id')
            ->select('movies.*', 'genres.name as genre_name')
            ->get();
        foreach ($rows as $row) {
            $id = $row->id;

            if(!isset($movies[$id])){
                $movies[$id] = [
                    'title' => $row->title,
                    'poster_path' => $row->poster_path,
                    'overview' => $row->overview,
                    'backdrop_path' => $row->backdrop_path,
                    'release_date' => $row->release_date,
                    'vote_average' => $row->vote_average,
                    'vote_count' => $row->vote_count,
                    'genres' => []
                ];
            }
            $movies[$id]['genres'][] = $row->genre_name;
        }

        return $movies;
    }
    public function filterByRating(int $rating)
    {
        $query = Movie::query();

        switch ($rating) {
            case 0:
                break;
            case 1:
                $query->whereBetween('vote_average', [0, 2]);
                break;
            case 2:
                $query->whereBetween('vote_average', [3, 5]);
                break;
            case 3:
                $query->whereBetween('vote_average', [6, 7]);
                break;
            case 4:
                $query->whereBetween('vote_average', [8, 9]);
                break;
            case 5:
                $query->whereBetween('vote_average', [10,10]);
                break;
            default:
                break;
        }

        return $query->orderBy('vote_average', 'desc')->get();

    }


}
