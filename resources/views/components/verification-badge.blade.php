<?php
@props(['user'])

@php
    $verification = $user->identityVerification ?? null;
    $isVerified = $user->profile && $user->profile->verification_status === 'verified';
    $hasFullVerification = $verification && $verification->status === 'approved' && $verification->location_verified;
@endphp

@if ($isVerified)
    <span class="inline-flex items-center gap-1 ml-1">
        @if ($hasFullVerification)
            <img src="{{ asset('images/verified-badge-purple.svg') }}" alt="Verificación completa" class="h-4 w-4">
        @else
            <img src="{{ asset('images/verified-badge.png') }}" alt="Identidad verificada" class="h-4 w-4">
        @endif
    </span>
@endif
