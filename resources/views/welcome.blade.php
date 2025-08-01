<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@php
    $movie = \App\Models\Movies::with(['details', 'trailers'])->find(1);

    // اگر فیلم وجود نداشت
    if (!$movie) {
    abort(404);
    }

    // حالا می‌تونی به داده‌ها دسترسی داشته باشی:
    $movieTitle = $movie->title;
    $movieDetails = $movie->details; // اطلاعات جزئیات
    $trailers = $movie->trailers;
@endphp
@auth
    <h1>خوش امدید</h1>
    <h3>{{$movieTitle}}</h3>
    <video src="{{$movie->movie_url}}" controls></video>
    <h4>{{ $trailers->first()->duration }}</h4>
    <a href="{{ route('logout') }}">خروج</a>
@endauth
@guest
    <a href="{{ route('auth.register') }}">register</a>
@endguest
</body>
</html>
