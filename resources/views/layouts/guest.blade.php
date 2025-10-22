<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Jobly')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/pin-sf.png') }}">
</head>
<body class="bg-[var(--bg)] min-h-screen flex flex-col">

@include('layouts.navigation')

{{-- Contenido principal --}}
<main class="flex-grow">
    @yield('content')
</main>

@vite(['resources/css/app.css','resources/js/app.js'])
</body>
</html>
