<!doctype html>
<html lang="fa" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('panel/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/css/Vazirmatn-font-face.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{$title ?? "پنل مدیریت"}}</title>
</head>
<body dir="rtl" x-data="{ sidebarOpen: false }">
<div
    x-show="sidebarOpen" x-cloak
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-40 md:hidden"
    x-transition.opacity
></div>

<section class="fixed left-0 w-full h-screen bg-white overflow-y-auto dark:bg-gray-700 dark:text-white md:pr-app-sidebar-w pb-app-header-h top-app-header-h"><div class="p-5 md:p-7">
        {{$slot}}
    </div></section>
@livewire('user-admin.sidebar')
@livewire('user-admin.header')
@livewire('components.toast-notification')
<script src="../../js/app.js"></script>
<script>
    (() => {
        let theme = localStorage.getItem('theme');
        if (!theme) {
            theme = 'dark'; // پیش‌فرض
            localStorage.setItem('theme', theme);
        }
        document.documentElement.classList.toggle('dark', theme === 'dark');
    })();
</script>
@include('partials.icons-sprite')
</body>
</html>
