<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('panel/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/css/Vazirmatn-font-face.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
{{$slot}}
</body>
</html>
