@props([
    'status' => 'none',
    'firstName',
    'lastName',
    'layout' => 'inline', // 'inline' o 'stacked'
])

@php
    $styles = [
        'none' => ['color' => 'text-gray-400', 'svg' => 'unverified.svg', 'label' => 'No verificado'],
        'pending' => ['color' => 'text-yellow-500', 'svg' => 'unverified.svg', 'label' => 'En revisión'],
        'verified' => ['color' => 'text-blue-600', 'svg' => 'verified-badge.svg', 'label' => 'Identidad verificada'],
        'full_verified' => ['color' => 'text-purple-600', 'svg' => 'verified-badge.svg', 'label' => 'Identidad y ubicación verificadas'],
    ];

    $icon = $styles[$status] ?? $styles['none'];
    $svgPath = public_path('images/badges/' . $icon['svg']);
    $svg = file_exists($svgPath) ? file_get_contents($svgPath) : '';

    // Ajuste visual del SVG
    $svg = preg_replace('/\s(width|height)="[^"]*"/i', '', $svg ?? '');
    $svg = preg_replace('/<svg\b(?![^>]*class=)/i', '<svg class="w-4 h-4 inline-block align-middle" ', $svg ?? '');
@endphp

@if ($layout === 'inline')
    {{-- Variante 1️⃣ Nombre + Insignia / Debajo: tipo de verificación --}}
    <div class="flex flex-col leading-tight">
        <div class="flex items-center gap-2 justify-start">
            <span class="font-semibold text-gray-900">{{ $firstName }} {{ $lastName }}</span>
            <span class="{{ $icon['color'] }}">{!! $svg !!}</span>
        </div>
        <p class="text-sm {{ $icon['color'] }}">{{ $icon['label'] }}</p>
    </div>
@else
    {{-- Variante 2️⃣ Nombre / Debajo: tipo de verificación + insignia --}}
    <div class="flex flex-col leading-tight">
        <span class="font-semibold text-gray-900">{{ $firstName }} {{ $lastName }}</span>
        <div class="flex items-center gap-1 justify-start">
            <p class="text-sm {{ $icon['color'] }}">{{ $icon['label'] }}</p>
            <span class="{{ $icon['color'] }}">{!! $svg !!}</span>
        </div>
    </div>
@endif

