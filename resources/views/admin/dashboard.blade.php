@extends('layouts.app')

@section('title', 'Panel Admin')

@section('content')
    <section class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-indigo-700 mb-4">Panel de administración</h1>

        <div class="bg-white shadow rounded-xl p-6 space-y-4">
            <p class="text-gray-600">¡Bienvenido/a, {{ auth()->user()->name }}!</p>
            <p class="text-sm text-gray-500">
                Desde aquí más adelante podrás gestionar usuarios, supervisar ofertas, verificar identidades,
                administrar reportes y más funciones administrativas del sistema.
            </p>
        </div>
    </section>
@endsection

