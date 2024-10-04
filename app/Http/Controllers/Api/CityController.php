<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Str;

class CityController extends Controller
{
    // Метод для добавления нового города
    public function store(Request $request)
    {
        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Генерация уникального slug на основе имени города
        $slug = Str::slug($validatedData['name']);
        $originalSlug = $slug;
        $count = 1;

        // Проверка уникальности slug
        while (City::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Создание нового города
        $city = City::create([
            'name' => $validatedData['name'],
            'slug' => $slug,
        ]);

        return response()->json(['message' => 'Город успешно добавлен', 'city' => $city], 201);
    }

    // Метод для удаления города
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json(['message' => 'Город успешно удален'], 200);
    }
}
