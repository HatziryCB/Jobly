@extends('layouts.dashboard')

@section('title', 'Dashboard de Empleado')

@section('dashboard-content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Postulaciones Realizadas</p>
            <h2 class="text-3xl font-bold text-purple-600">{{ $applicationsMade }}</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Procesadas</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $applicationsProcessed }}</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500 mb-2">Rechazadas</p>
            <h2 class="text-3xl font-bold text-red-600">{{ $applicationsRejected }}</h2>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Ofertas Recomendadas</h3>
        <div class="grid gap-4">
            @forelse ($recommendedOffers as $offer)
                <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-bold text-purple-700">{{ $offer->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $offer->category }}</p>
                        <p class="text-sm text-gray-500">{{ $offer->location_text }}</p>
                        <p class="text-sm text-gray-500">Q{{ $offer->min_payment }} - Q{{ $offer->max_payment }}</p>
                    </div>
                    <a href="{{ route('offers.show', $offer->id) }}" class="text-indigo-600 hover:underline">Ver más</a>
                </div>
            @empty
                <p class="text-gray-500">No hay recomendaciones disponibles.</p>
            @endforelse
        </div>
    </div>
@endsection
