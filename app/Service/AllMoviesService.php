<?php

namespace App\Service;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;

class AllMoviesService
{

    private function getAndSanitizeMovies(Builder $query): array
    {
        return $query->select('movies.*', 'movie_details.*', 'movies.id as movie_id')
            ->join('movie_details', 'movies.id', '=', 'movie_details.movie_id')
            ->get()

            ->map(function ($movie) {

                if (!is_array($movie->genres)) {
                    $movie->genres = [];
                }
                return $movie;
            })
            ->toArray();
    }

    public function returnMovies(): array
    {
        $query = Movie::query();
        return $this->getAndSanitizeMovies($query);
    }

    public function filterByRating(int $rating): array
    {
        $query = Movie::query();

        switch ($rating) {
            case 0:
                break;
            case 1:
                $query->whereBetween('vote_average', [0, 2.99]);
                break;
            case 2:
                $query->whereBetween('vote_average', [3, 5.99]);
                break;
            case 3:
                $query->whereBetween('vote_average', [6, 7.99]);
                break;
            case 4:
                $query->whereBetween('vote_average', [8, 9.99]);
                break;
            case 5:
                $query->where('vote_average', 10);
                break;
            default:
                break;
        }

        return $this->getAndSanitizeMovies($query->orderBy('vote_average', 'desc'));
    }
}

