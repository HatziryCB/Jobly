@extends('layouts.dashboard')

@section('title', 'Detalles de la oferta')

@section('content')
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-lg space-y-6">

        {{-- Título --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">{{ $offer->title }}</h1>

            {{-- Botones de acción (solo para el empleador) --}}
            @can('update', $offer)
                <div class="flex space-x-2">
                    <a href="{{ route('offers.edit', $offer) }}" class="text-lime-600 hover:text-lime-800">
                        <i class="fas fa-pen-to-square text-xl"></i>
                    </a>
                    <form action="{{ route('offers.destroy', $offer) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700">
                            <i class="fas fa-trash text-xl"></i>
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        {{-- Empleador y calificación --}}
        <div class="flex items-center gap-2 text-gray-600">
            <span class="font-semibold text-indigo-700">
                @if($offer->user)
                    {{ $offer->user->first_name }} {{ $offer->user->last_name }}
                @else<a href="{{ route('profile.show', $offer->user->id) }}" class="text-indigo-600 hover:underline">
                        {{ $offer->user->first_name }} {{ $offer->user->last_name }}
                    </a>
                    <span class="text-red-500">[Usuario no asignado]</span>
                @endif
            </span>
            {{-- Calificación --}}
            <span class="text-yellow-500">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star"></i>
                @endfor
            </span>
                </div>
                {{-- Etiqueta de categoría --}}
            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mt-4">
                {{ $offer->category }}
            </span>

        {{-- Info resumida con íconos --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center mt-6">
            {{-- Pago --}}
            <div>
                <i class="fas fa-money-bill-wave fa-2x text-green-600 mb-1"></i>
                <div class="text-gray-800 font-semibold">
                    Q{{ $offer->payment_min ?? '-' }} - Q{{ $offer->payment_max ?? '-' }}
                </div>
                <div class="text-sm text-gray-500">Pago estimado</div>
            </div>

            {{-- Ubicación --}}
            <div>
                <i class="fas fa-map-marker-alt fa-2x text-pink-500 mb-1"></i>
                <div class="text-gray-800 font-semibold">
                    {{ $offer->location_text ?? '-' }}
                </div>
                <div class="text-sm text-gray-500">Ubicación</div>
            </div>

            {{-- Duración --}}
            <div>
                <i class="fas fa-clock fa-2x text-yellow-500 mb-1"></i>
                <div class="text-gray-800 font-semibold">
                    {{ $offer->estimated_duration_quantity ?? '-' }} {{ $offer->estimated_duration_unit ?? '-' }}
                </div>
                <div class="text-sm text-gray-500">Duración</div>
            </div>

            {{-- Cantidad (fijo por ahora o cuando lo implementes) --}}
            <div>
                <i class="fas fa-list-ol fa-2x text-cyan-500 mb-1"></i>
                <div class="text-gray-800 font-semibold">10</div>
                <div class="text-sm text-gray-500">Cantidad</div>
            </div>
        </div>

        {{-- Descripción --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Descripción</h2>
            <p class="text-gray-700 leading-relaxed">{{ $offer->description }}</p>
        </div>

        {{-- Requisitos (si hay) --}}
        @if($offer->requirements)
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-1">Requisitos</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $offer->requirements }}</p>
            </div>
        @endif
        @can('update', $offer)
            <div class="flex gap-2 mt-4">
                <a href="{{ route('offers.edit', $offer) }}" class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-edit fa-lg"></i> Editar
                </a>
                <form method="POST" action="{{ route('offers.destroy', $offer) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash-alt fa-lg"></i> Eliminar
                    </button>
                </form>
            </div>
        @endcan
        @role('employee')
        <form action="{{ route('applications.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="offer_id" value="{{ $offer->id }}">
            <button type="submit" class="bg-purple-500 text-white font-bold px-6 py-2 rounded-full hover:bg-purple-600 transition">
                Postularme a esta oferta
            </button>
        </form>
        @endrole
    </div>
@endsection
