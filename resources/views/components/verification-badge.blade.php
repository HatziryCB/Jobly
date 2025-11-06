@props([
    'status' => 'none',
    'firstName',
    'lastName'
])

@php
    $styles = [
        'none' => [
            'color' => 'text-yellow-500',
            'svg' => 'unverified.svg',
            'labels' => ['No verificado'],
        ],
        'pending' => [
            'color' => 'text-yellow-500',
            'svg' => 'unverified.svg',
            'labels' => ['En revisión'],
        ],
        'verified' => [
            'color' => 'text-blue-600',
            'svg' => 'verified-badge.svg',
            'labels' => ['Identidad verificada'],
        ],
        'full_verified' => [
            'color' => 'text-purple-600',
            'svg' => 'verified-badge.svg',
            'labels' => ['Identidad verificada', 'Ubicación verificada'],
        ],
    ];

    $icon = $styles[$status] ?? $styles['none'];
@endphp

<div class="text-center">
    <div class="flex justify-center items-center gap-2">
        <span class="text-gray-800 font-semibold text-base leading-none">
            {{ $firstName }} {{ $lastName }}
        </span>
        <span class="inline-block {{ $icon['color'] }} w-5 h-5">
            <div class="w-5 h-5">
                {!! file_get_contents(public_path('images/badges/' . $icon['svg'])) !!}
            </div>
        </span>
    </div>

    <div class="mt-1 text-sm text-gray-600 leading-tight">
        @foreach ($icon['labels'] as $label)
            <p>{{ $label }}</p>
        @endforeach
    </div>
</div>
