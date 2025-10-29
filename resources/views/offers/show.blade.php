@extends('layouts.dashboard')

@section('title', 'Detalles de la oferta')

@section('content')
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-lg space-y-6">

        {{-- Título --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">{{ $offer->title }}</h1>
            {{-- Botones de acción --}}
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
                @else
                    <a href="{{ route('profile.show', $offer->user->id) }}" class="text-indigo-600 hover:underline">
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
        {{-- Categoría --}}
        @if($offer->category)
            <span class="inline-block bg-purple-100 text-purple-700 px-4 py-1 rounded-full text-sm font-semibold mb-4">
{{ ucfirst($offer->category) }}
</span>
        @endif


        {{-- Información de la oferta --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-8">
            {{-- Pago estimado --}}
            <div>
                <div class="text-4xl mb-2">
                    <i class="fas fa-money-bill-wave text-green-500"></i>
                </div>
                <p class="font-bold text-lg">
                    Q{{ $offer->min_payment ?? '--' }} - Q{{ $offer->max_payment ?? '--' }}
                </p>
                <p class="text-sm text-gray-600">Pago estimado</p>
            </div>

            {{-- Ubicación --}}
            <div>
                <div class="text-4xl mb-2">
                    <i class="fas fa-map-marker-alt text-pink-500"></i>
                </div>
                <p class="font-bold text-lg">
                    {{ $offer->location_text ?? '--' }}
                </p>
                <p class="text-sm text-gray-600">Ubicación</p>
            </div>

            {{-- Duración estimada --}}
            <div>
                <div class="text-4xl mb-2">
                    <i class="fas fa-clock text-yellow-500"></i>
                </div>
                <p class="font-bold text-lg">
                    @if ($offer->estimated_duration_unit)
                        {{ $offer->estimated_duration_quantity ?? '1' }} {{ strtolower($offer->estimated_duration_unit) }}
                    @else
                        --
                    @endif
                </p>
                <p class="text-sm text-gray-600">Duración</p>
            </div>
        </div>

        {{-- Descripción --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Descripción</h2>
            <p class="text-gray-700 leading-relaxed">{{ $offer->description }}</p>
        </div>

        {{-- Requisitos --}}
        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-2">Requisitos del trabajo</h3>
            <p class="text-gray-700 whitespace-pre-line">
                {{ $offer->requirements ?? 'No se especificaron requisitos.' }}
            </p>
        </div>

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
        <form action="#" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="offer_id" value="{{ $offer->id }}">
            <textarea name="message" class="w-full rounded-xl mb-3" placeholder="Mensaje al empleador (opcional)"></textarea>
            <button type="submit" class="bg-purple-500 text-white font-bold px-6 py-2 rounded-full hover:bg-purple-600 transition">
                Postularme a esta oferta
            </button>
        </form>
        @endrole
    </div>
@endsection
