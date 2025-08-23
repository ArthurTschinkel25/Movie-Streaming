<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ]);

        if ($response->successful()) {
            $genres = $response->json()['genres'];

            foreach ($genres as $genre) {
                DB::table('genres')->updateOrInsert(
                    ['id' => $genre['id']],
                    ['name' => $genre['name'], 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }
    }
}
