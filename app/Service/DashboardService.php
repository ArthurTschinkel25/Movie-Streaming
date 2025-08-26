<?php

namespace App\Service;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function returnDashboardMovies()
    {
        try {
            $recentMovies = Movie::select('movies.*', 'movie_details.*')
                ->join('movie_details', 'movie_details.movie_id', '=', 'movies.id')
                ->whereYear('release_date', now()->year)
                ->where('movie_details.runtime', '!=', '0')
                ->where('vote_average', '!=', '0')
                ->where('vote_count', '!=', '0')
                ->orderBy('release_date', 'desc')
                ->limit(15)
                ->get()
                ->map(function($movie) {
                    $movieArray = $movie->toArray();
                    $movieArray['genres'] = json_decode($movie->genres, true) ?? [];
                    return $movieArray;
                })
                ->toArray();

            $goodRatingMovies = Movie::select('movies.*', 'movie_details.*')
                ->join('movie_details', 'movie_details.movie_id', '=', 'movies.id')
                ->where('movie_details.runtime', '!=', '0')
                ->where('vote_average', '>=', 8.5)
                ->where('vote_count', '>=', 1000)
                ->orderBy('vote_average', 'desc')
                ->limit(15)
                ->get()
                ->map(function($movie) {
                    $movieArray = $movie->toArray();
                    $movieArray['genres'] = json_decode($movie->genres, true) ?? [];
                    return $movieArray;
                })
                ->toArray();

            $mostPopularMovies = Movie::select('movies.*', 'movie_details.*')
                ->join('movie_details', 'movie_details.movie_id', 'movies.id')
                ->where('movie_details.runtime', '!=', '0')
                ->where('vote_average', '!=', '0')
                ->where('vote_count', '!=', '0')
                ->limit(15)
                ->orderBy('popularity', 'desc')
                ->get()
                ->map(function($movie) {
                    $movieArray = $movie->toArray();
                    $movieArray['genres'] = json_decode($movie->genres, true) ?? [];
                    return $movieArray;
                })
                ->toArray();

            return [
                'recentMovies' => $recentMovies,
                'goodRatingMovies' => $goodRatingMovies,
                'mostPopularMovies' => $mostPopularMovies
            ];

        } catch (\Exception $e) {
            report($e);
            return [
                'recentMovies' => [],
                'goodRatingMovies' => [],
                'mostPopularMovies' => []
            ];
        }
    }
}
