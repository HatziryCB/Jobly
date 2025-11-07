<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Jobly')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/pin-sf.png') }}">
    <title>@yield('title', config('app.name', 'Jobly'))</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body { opacity: 0; transition: opacity 0.2s ease-in; }
        html[data-vite-dev-id] body, body.loaded { opacity: 1; }
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">

</head>
<body class="font-sans antialiased bg-[var(--bg)] min-h-screen flex flex-col">

@include('layouts.navigation')

@isset($header)
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endisset

{{-- Contenido principal --}}
<main class="py-6 px-4 sm:px-6 lg:px-8">
    @yield('content')
</main>
@stack('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    window.addEventListener('load', () => document.body.classList.add('loaded'));
</script>
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
<script src="https://cdn.jsdelivr.net/npm/overlapping-marker-spiderfier-leaflet@1.0.3/oms.min.js"></script>

</body>
</html>
