<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Jobly') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/public/images/jobly-icon.ico') }}">

    {{-- Fonts opcional --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/js/app.js', 'resources/css/custom.css', 'resources/js/custom.js'])
</head>
<body class="font-sans antialiased">
@include('layouts.navigation')
{{ $slot }}

</body>
</html>
