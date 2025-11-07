@props(['status' => 'none'])

@php
    $labels = [
        'none'          => ['No verificado', 'text-red-500'],
        'pending'       => ['En revisión', 'text-yellow-500'],
        'verified'      => ['Identidad verificada', 'text-blue-600'],
        'full_verified' => ['Identidad y ubicación verificadas', 'text-purple-600'],
    ];
    [$text, $color] = $labels[$status] ?? $labels['none'];
@endphp

<p class="text-sm {{ $color }} mt-1 leading-tight">
    {{ $text }}
</p>
