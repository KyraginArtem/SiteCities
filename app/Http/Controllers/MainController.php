<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class MainController extends Controller
{
    // Метод для главной страницы
    public function index(Request $request, $city = null)
    {
        // Если передан город в URL
        if ($city) {
            $selectedCity = City::where('slug', $city)->firstOrFail();
            // Обновляем выбранный город в сессии
            session(['selected_city' => $selectedCity]);
        } else {
            // Если город не передан, берем его из сессии
            $selectedCity = session('selected_city');
            if ($selectedCity) {
                // Редиректим на страницу с выбранным городом
                return redirect()->to('/' . $selectedCity->slug);
            }
        }

        $cities = City::all();

        // Возвращаем представление с обновленной сессией
        return view('index', compact('cities', 'selectedCity'));
    }

    // Метод для страницы "О нас"
    public function about(Request $request, $city)
    {
        // Ищем город по slug
        $selectedCity = City::where('slug', $city)->firstOrFail();
        // Возвращаем представление about.blade.php с выбранным городом
        return view('about', compact('selectedCity'));
    }

    // Метод для страницы "Новости"
    public function news(Request $request, $city)
    {
        // Ищем город по slug
        $selectedCity = City::where('slug', $city)->firstOrFail();
        // Возвращаем представление news.blade.php с выбранным городом
        return view('news', compact('selectedCity'));
    }
}
