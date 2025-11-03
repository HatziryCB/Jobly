<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/pin-sf.png') }}">

    <title>@yield('title', config('app.name', 'Jobly'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { opacity: 0; transition: opacity 0.2s ease-in; }
        html[data-vite-dev-id] body, body.loaded { opacity: 1; }
    </style>
    <script>
        window.addEventListener('load', () => document.body.classList.add('loaded'));
    </script>

</head>
<body class="font-sans antialiased bg-[var(--bg)] min-h-screen flex flex-col">
<div class="min-h-screen bg-gray-50">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>
</div>
@stack('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
