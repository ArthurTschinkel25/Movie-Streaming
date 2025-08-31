<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MyListMoviesController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();

        $movies = Movie::select('movies.*', 'movie_details.*', 'users.name')
            ->join('movie_details', 'movies.id', '=', 'movie_details.movie_id')
            ->join('movies_user', 'movies.id', '=', 'movies_user.movie_id')
            ->join('users', 'movies_user.user_id', '=', 'users.id')
            ->where('users.id', '=', $user_id)
            ->get()
            ->map(function($movie) {
                $movieArray = $movie->toArray();

                $genres = json_decode($movie->genres, true);


                if (is_array($genres)) {
                    $movieArray['genres'] = $genres;
                } elseif (is_string($genres)) {
                    $movieArray['genres'] = [$genres];
                } else {
                    $movieArray['genres'] = [];
                }

                return $movieArray;
            });

        $totalMovies = count($movies);

        return view('Movies.MyListMovies.index', [
            'movies' => $movies,
            'totalMovies' => $totalMovies
        ]);
    }
}
