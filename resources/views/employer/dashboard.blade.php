@extends('layouts.dashboard')

@section('title', 'Panel del Empleador')
@section('dashboard-title', 'Bienvenido Empleador')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Ejemplo de resumen rápido --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg">Ofertas activas</h3>
            <p class="text-3xl">{{ $activeOffers }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg">Contrataciones</h3>
            <p class="text-3xl">{{ $hiredOffers }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg">Postulaciones recibidas</h3>
            <p class="text-3xl">{{ $applicationsReceived }}</p>
        </div>
    </div>

    {{-- Aquí puedes mostrar últimas ofertas, gráficos, etc --}}
@endsection

