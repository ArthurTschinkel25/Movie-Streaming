<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\MovieDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = env('TMDB_API_KEY');
        $movies = Movie::all();

        foreach ($movies as $movie) {
            try {
                $url = "https://api.themoviedb.org/3/movie/{$movie->id}?api_key=$apiKey&language=pt-BR";
                $response = Http::get($url);

                if (!$response->ok()) {
                    throw new \Exception("Erro ao buscar o filme ID: {$movie->id}. Status: " . $response->status());
                }

                $data = $response->json();

                $genres = collect($data['genres'] ?? [])
                    ->pluck('name')
                    ->toArray();

                $originCountry = implode(', ', $data['origin_country'] ?? []);

                MovieDetails::updateOrCreate(
                    ['movie_id' => $data['id']],
                    [
                        'runtime'        => $data['runtime'] ?? null,
                        'popularity'     => $data['popularity'] ?? null,
                        'imdb_id'        => $data['imdb_id'] ?? null,
                        'origin_country' => $originCountry,
                        'adult'          => $data['adult'] ?? false,
                        'budget'         => $data['budget'] ?? 0,
                        'genres' => json_encode($genres, JSON_UNESCAPED_UNICODE),
                    ]
                );

            } catch (\Exception $e) {
                Log::error("Erro ao processar o filme ID {$movie->id}: " . $e->getMessage());
                continue;
            }
        }
    }
}
