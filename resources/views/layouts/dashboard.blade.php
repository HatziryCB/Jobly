<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Usuario')</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex">
    {{-- Sidebar --}}
    @include('components.dashboard.sidebar')

    {{-- Contenido principal --}}
    <div class="flex-1 p-6 overflow-y-auto">
        @include('components.dashboard.header')
        @yield('content')
    </div>
</div>
</body>
</html>
