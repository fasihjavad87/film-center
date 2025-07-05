<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ url('auth/images/svgexport-2.svg') }}">
    {{--    <link rel="stylesheet" href="{{ url('auth/css/all.css') }}"/>--}}
    {{--    <link rel="stylesheet" href="{{ url('auth/css/fontiran.css') }}"/>--}}
    {{--    <link rel="stylesheet" href="{{ url('auth/css/input.css') }}"/>--}}
    <link rel="stylesheet" href="{{ url('auth/css/main.css') }}"/>
</head>
<body class="register-login-body">
<!-- Spinner (hidden after load) -->
<div id="loading-spinner" class="parent-spinner">
    <div class="spinner spinner-border"></div>
</div>

<!-- Form Wrapper -->
<div class="parent-img-title-form">
    <!-- Logo -->
    <div class="parent-img">
        <img src="{{ url('auth/images/svgexport-2.svg') }}" alt="لوگو">
    </div>

    {{$slot}}

    <script type="module" src="{{ url('auth/js/main.js') }}" defer></script>
</body>
</html>
