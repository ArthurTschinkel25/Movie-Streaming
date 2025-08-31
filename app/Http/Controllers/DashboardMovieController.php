<?php

namespace App\Http\Controllers;

use App\Models\MovieDetails;
use App\Models\MoviesUser;
use App\Service\DashboardService;
use App\Service\MyListMoviesService;
use Illuminate\Http\Request;
use App\Service\AllMoviesService;
use App\Models\Movie;

class DashboardMovieController extends Controller
{

    public function __construct(private DashboardService $dashboardService, private MyListMoviesService $myLIstMoviesService)
    {

    }
    public function saveFavoriteMovie(Request $request)
    {
        $this->myLIstMoviesService->saveFavoriteMovie($request);
    }

    public function index()
    {
        $dashboardMovies = $this->dashboardService->returnDashboardMovies();
        return view('Movies.movie-dashboard', [
            'dashboardMovies' => $dashboardMovies
        ]);
    }
}
