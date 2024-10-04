<!DOCTYPE html>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
<header>
    @if($selectedCity)
        <p>Выбранный город: <strong>{{ $selectedCity->name }}</strong></p>
    @else
        <p>Выберите город:</p>
    @endif
</header>

<main>
    <h1>Список городов:</h1>
    <ul>
        @foreach($cities as $city)
            <li>
                <a href="{{ url($city->slug) }}" @if($selectedCity && $city->id === $selectedCity->id) style="font-weight: bold;" @endif>
                    {{ $city->name }}
                </a>
            </li>
        @endforeach
    </ul>
</main>
</body>
</html>
