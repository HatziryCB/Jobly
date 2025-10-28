@extends('layouts.dashboard')

@section('title', 'Dashboard de Empleador')

@section('dashboard-content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Ofertas Activas</p>
            <h2 class="text-3xl font-bold text-purple-600">{{ $activeOffers }}</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Contratadas</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $hiredOffers }}</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Postulaciones Recibidas</p>
            <h2 class="text-3xl font-bold text-blue-600">{{ $applicationsReceived }}</h2>
        </div>
    </div>
@endsection
