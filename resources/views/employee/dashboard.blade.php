@extends('layouts.employee')

@section('title', 'Panel de empleado')

@section('content')
    <x-employee.header />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        {{-- Sidebar izquierdo --}}
        <div>
            <x-employee.sidebar />
        </div>

        {{-- Contenido central --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <x-dashboard.stat title="Postulaciones enviadas" value="8" />
                <x-dashboard.stat title="Aceptadas" value="3" />
                <x-dashboard.stat title="Rechazadas" value="2" />
            </div>

            {{-- Postulaciones recientes --}}
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Mis últimas postulaciones</h2>
                @forelse($applications as $app)
                    <div class="border rounded p-3 mb-2">
                        <p class="text-sm font-medium text-gray-700">
                            {{ $app->offer->title }} —
                            <span class="text-xs text-gray-500">Estado: {{ ucfirst($app->status) }}</span>
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">Aún no has realizado postulaciones.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
