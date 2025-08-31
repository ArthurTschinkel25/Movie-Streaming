<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MovieSeeder extends Seeder
{

    public function run()
    {
        $apiKey = env('TMDB_API_KEY');

        for ($page = 1; $page <= 25; $page++) {
            $apiUrl = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=pt-BR&page={$page}";
            $response = @file_get_contents($apiUrl);

            if ($response === false) {
                echo "Erro ao buscar a página {$page}.\n";
                continue;
            }

            $data = json_decode($response, true);

            if (!isset($data['results'])) continue;

            foreach ($data['results'] as $movie) {
                Movie::create([
                    'title' => $movie['title'] ?? null,
                    'original_title' => $movie['original_title'] ?? null,
                    'overview' => $movie['overview'] ?? null,
                    'poster_path' => $movie['poster_path'] ?? null,
                    'backdrop_path' => $movie['backdrop_path'] ?? null,
                    'release_date' => !empty($movie['release_date']) ? $movie['release_date'] : null,
                    'vote_average' => $movie['vote_average'] ?? null,
                    'vote_count' => $movie['vote_count'] ?? null,
                    'genre_ids' => $movie['genre_ids'] ?? [],
                ]);
            }

            sleep(1);
        }

        echo "Todos os dados foram salvos com sucesso.\n";
    }

}
