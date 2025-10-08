<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name','Jobly'))</title>

    @vite(['resources/js/app.js', 'resources/css/custom.css', 'resources/css/app.css', 'resources/js/custom.js'])

    {{-- Lugar para inyecciones opcionales (p.ej. mapas, icon libs) --}}
    @stack('head')
</head>
<body class="min-h-screen bg-[var(--bg)] text-[var(--text)] flex flex-col">
@include('layouts.navigation')

<main class="flex-1">
    @yield('content')
</main>

{{-- @includeWhen(View::exists('components.home.footer'), 'components.home.footer')--}}
</body>
</html>
