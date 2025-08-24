<?php

namespace App\Service;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class DashboardService{

    public function returnDashboardMovies(){

        try{
            $recentMovies = Movie::whereYear('release_date', 2025)
                ->limit(15)
                ->orderby('release_date', 'desc')
                ->get();

            $goodRatingMovies = Movie::Where('vote_average', '>=', 8.5)
                ->Where('vote_count', '>=', 1000)
                ->orderby('vote_average', 'desc')
                ->limit(15)
                ->get();
            $dashboardMovies = ['recentMovies' => $recentMovies, 'goodRatingMovies' => $goodRatingMovies];
        }
        catch (\Exception $e){
            echo "Algum erro ocorreu ao tentar buscar os filmes " . $e->getMessage();
            return;
        }
        return $dashboardMovies;
    }

}
