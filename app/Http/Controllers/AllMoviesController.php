<?php
namespace App\Http\Controllers;

use App\Models\MovieDetails;
use Illuminate\Http\Request;
use App\Service\MovieService;
use App\Models\Movie;

class AllMoviesController extends Controller
{

    public function __construct(private MovieService $movieService)
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

    public function populatedMoviesDetailsFromApi()
    {
        $apiKey = config('services.tmdb.api_key');
        $allMovies = Movie::all();

        foreach($allMovies as $movie) {
            try {
                $url = "https://api.themoviedb.org/3/movie/{$movie->id}?api_key=$apiKey&language=pt-BR";
                $response = file_get_contents($url);

                if ($response === false) {
                    throw new \Exception("Failed to fetch data for movie ID: {$movie->id}");
                }

                $movieData = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception("Invalid JSON response for movie ID: {$movie->id}");
                }

                $detailsData = [
                    'movie_id' => $movie->id,
                    'runtime' => $movieData['runtime'] ?? null,
                    'popularity' => $movieData['popularity'] ?? null,
                    'imdb_id' => $movieData['imdb_id'] ?? null,
                    'origin_country' => isset($movieData['origin_country']) ? implode(', ', $movieData['origin_country']) : null,
                    'adult' => $movieData['adult'] ?? false,
                    'budget' => $movieData['budget'] ?? null,
                ];

                MovieDetails::updateOrCreate(
                    ['movie_id' => $movie->id],
                    $detailsData
                );

                usleep(250000);

            } catch (\Exception $e) {
                \Log::error("Error processing movie ID {$movie->id}: " . $e->getMessage());
                continue;
            }
        }

        return "Os filmes foram salvos/atualizados no banco de dados com sucesso!";
    }

    public function filter(Request $request)
    {
        $dados = $request->all();

        $rating = (int) $dados['filtroNota'];

        $filteredMovies = $this->movieService->filterByRating($rating);

        return back()->with('filteredMovies', $filteredMovies);
    }


}
