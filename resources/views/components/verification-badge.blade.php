@props([
    'status' => 'none',
    'firstName',
    'lastName',
    'layout' => 'inline', // 'inline' ó 'center'
])

@php
    $styles = [
        'none' => ['color' => 'text-yellow-500', 'svg' => 'unverified.svg'],
        'pending' => ['color' => 'text-yellow-500', 'svg' => 'unverified.svg'],
        'verified' => ['color' => 'text-blue-600', 'svg' => 'verified-badge.svg'],
        'full_verified' => ['color' => 'text-purple-600', 'svg' => 'verified-badge.svg'],
    ];
    $icon = $styles[$status] ?? $styles['none'];

    $svgPath = public_path('images/badges/'.$icon['svg']);
    $svg = file_exists($svgPath) ? file_get_contents($svgPath) : '';

    $svg = preg_replace('/\s(width|height)="[^"]*"/i', '', $svg ?? '');

    $svg = preg_replace('/<svg\b(?![^>]*class=)/i', '<svg class="w-[1em] h-[1em] inline align-[-2px]" ', $svg ?? '');
@endphp

<div class="{{ $layout === 'center' ? 'text-center' : 'flex items-center gap-2' }}">
    <span class="font-semibold text-gray-900 leading-none">
        {{ $firstName }} {{ $lastName }}
    </span>
    <span class="{{ $icon['color'] }} shrink-0">
        {!! $svg !!}
    </span>
</div>
