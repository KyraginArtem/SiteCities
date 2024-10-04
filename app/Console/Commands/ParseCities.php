<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ParseCities extends Command
{
    protected $signature = 'parse:cities';
    protected $description = 'Parse cities from hh.ru API';

    public function handle()
    {
        $response = Http::get('https://api.hh.ru/areas');
        $areas = $response->json();

        // areas[0] — это Россия
        foreach ($areas[0]['areas'] as $region) {
            foreach ($region['areas'] as $city) {
                $slug = Str::slug($city['name']);  // Генерируем slug из названия города

                // Проверка на уникальность slug
                $originalSlug = $slug;
                $count = 1;
                while (City::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                City::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $city['name'], 'slug' => $slug]
                );
            }
        }

        $this->info('Cities parsed and stored in the database.');
    }
}
