<?php
namespace App\Http\Controllers;

use App\Models\MovieDetails;
use Illuminate\Http\Request;
use App\Service\AllMoviesService;
use App\Models\Movie;

class AllMoviesController extends Controller
{

    public function __construct(private AllMoviesService $movieService)
    {

    }

    public function index()
    {
        $movies = $this->movieService->returnMovies();
        $filteredMovies = session('filteredMovies');

        $movies = $filteredMovies ?? $movies;

        $totalMovies = count($movies);
        return view('Movies.all-movies', [
            'movies' => $movies,
            'totalMovies' => $totalMovies,
        ]);
    }
    public function filter(Request $request)
    {
        $dados = $request->all();

        $rating = (int) $dados['filtroNota'];

        $filteredMovies = $this->movieService->filterByRating($rating);

        return back()->with('filteredMovies', $filteredMovies);
    }


}
