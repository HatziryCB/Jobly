@extends('layouts.dashboard')

@section('dashboard-content')
    <h2 class="text-2xl font-bold mb-4">Mis Postulaciones</h2>

    @forelse ($applications as $application)
        <div class="border rounded-lg p-4 mb-4 shadow-sm bg-white">
            <h3 class="font-semibold text-xl">{{ $application->offer->title }}</h3>
            <p class="text-gray-700">{{ $application->message ?? 'Sin mensaje' }}</p>
            <p class="text-sm text-gray-500 mt-1">Estado: {{ ucfirst($application->status) }}</p>
        </div>
    @empty
        <p>No tienes postulaciones aún.</p>
    @endforelse
@endsection
