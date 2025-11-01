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
        <h3 class="text-2xl font-bold mb-6 text-gray-700">Ofertas Recomendadas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
            @forelse ($recommendedOffers as $offer)
                <div class="bg-white p-5 rounded-xl shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center hover:shadow-lg transition-all duration-200 border border-gray-100">

                    {{-- Contenido de la Oferta --}}
                    <div class="mb-3 sm:mb-0">
                        <h4 class="text-xl font-bold text-indigo-800">{{ $offer->title }}</h4>
                        <p> <i class="fas fa-map-marker-alt mr-2 text-yellow-400"></i>{{ $offer->location_text }}</p>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-6">{{ Str::limit($offer->description, 300) }}</p>

                        {{-- Etiquetas de Categoría --}}
                        <div class="mt-2 flex items-center gap-2">
                            @php
                                // Lógica de colores simple para la recomendada
                                $categoryColor = match($offer->category) {
                                    'Limpieza' => 'bg-pink-100 text-pink-700',
                                    'Pintura' => 'bg-blue-100 text-blue-700',
                                    'Mudanza' => 'bg-green-100 text-green-700',
                                    'Jardinería' => 'bg-lime-100 text-lime-700',
                                    'Reparaciones' => 'bg-yellow-100 text-yellow-700',
                                    'Electricidad' => 'bg-orange-100 text-orange-700',
                                    'Plomería' => 'bg-cyan-100 text-cyan-700',
                                    'Eventos' => 'bg-purple-100 text-purple-700',
                                    'Cuidado de niños' => 'bg-rose-100 text-rose-700',
                                    'Mecánica' => 'bg-amber-100 text-amber-700',
                                    'Construcción' => 'bg-sky-100 text-sky-700',
                                    'Asistencia' => 'bg-teal-100 text-teal-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $categoryColor }}">
                            {{ $offer->category }}
                        </span>
                        </div>
                        <div class="flex justify-between items-center mt-5">
                            <div class="flex gap-5">
                                <p class="text-green-600">
                                    <i class="fas fa-money-bill-wave text-green-500"></i>
                                    Q{{ $offer->pay_min }} - Q{{ $offer->pay_max }}
                                </p>
                                <div class="flex gap-5">
                                    <a href="{{ route('offers.show', $offer->id) }}"
                                       class="bg-indigo-500 text-white px-2 py-2 rounded-xl text-sm font-medium hover:bg-indigo-600 transition-colors flex-shrink-0">
                                        Ver oferta
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 bg-gray-50 p-4 rounded-xl shadow-sm">No hay recomendaciones disponibles por el momento.</p>
            @endforelse
        </div>
    </div>
@endsection
