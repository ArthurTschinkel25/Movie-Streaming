<?php

namespace App\Http\Controllers;

use App\Models\MovieDetails;
use Illuminate\Http\Request;
use App\Service\MovieService;
use App\Models\Movie;

class MovieDashboardController extends Controller
{


    public function index(){
        return view('Movies.movie-dashboard');
    }
}
