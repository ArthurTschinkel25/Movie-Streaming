<?php

namespace App\Service;

use App\Models\MoviesUser;

class MyListMoviesService
{
    public function saveFavoriteMovie($data){
        $user_id = auth()->id();
        $movie_id = $data['movie_id'];

        $favoriteMovie = MoviesUser::create([
            'user_id' => $user_id,
            'movie_id' => $movie_id,
        ]);

        if ($favoriteMovie['success']) {
            return back()->with('success', $favoriteMovie['message']);
        } else {
            return back()->with('error', $favoriteMovie['message']);
        }
    }
}
