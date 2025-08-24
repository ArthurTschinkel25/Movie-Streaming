<?php

namespace App\Http\Controllers;

use App\Models\MovieDetails;
use App\Service\DashboardService;
use Illuminate\Http\Request;
use App\Service\AllMoviesService;
use App\Models\Movie;

class DashboardMovieController extends Controller
{


    public function index(){

        $dashboardMovies = (new DashboardService())->returnDashboardMovies();
        return view('Movies.movie-dashboard', [
            'dashboardMovies' => $dashboardMovies
        ]);
    }
}
