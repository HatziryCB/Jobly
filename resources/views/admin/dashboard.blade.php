@extends('layouts.dashboard')

@section('title', 'Panel Admin')

@section('dashboard-content')
    <h2 class="text-2xl font-semibold mb-6">Panel de Administración</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-5 bg-blue-100 rounded-2xl">
            <p class="text-gray-700">Solicitudes pendientes</p>
            <p class="text-3xl font-bold text-blue-700">{{ $pendingCount }}</p>
        </div>
        <div class="p-5 bg-green-100 rounded-2xl">
            <p class="text-gray-700">Usuarios verificados</p>
            <p class="text-3xl font-bold text-green-700">{{ $verifiedCount }}</p>
        </div>
        <div class="p-5 bg-purple-100 rounded-2xl">
            <p class="text-gray-700">Verificaciones de ubicación</p>
            {{--<p class="text-3xl font-bold text-purple-700">{{ $locationVerifiedCount }}</p>--}}
        </div>
    </div>

    <div class="mt-10">
        <a href="{{ route('admin.verifications.index') }}"
           class="inline-flex items-center bg-[var(--brand-primary)] text-white font-semibold px-2 py-2 rounded-2xl hover:bg-[var(--brand-secondary)] transition">
            Revisar solicitudes de verificación
        </a>
    </div>
@endsection
