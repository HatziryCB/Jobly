@extends('layouts.dashboard')

@section('title', 'Mis Ofertas')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Listado de ofertas --}}
        <div class="lg:w-1/2 space-y-4">
            {{-- Buscador y filtro --}}
            <div class="flex gap-2">
                <input type="text" placeholder="Buscar oferta..." class="w-full rounded-xl border px-4 py-2">
                <select class="rounded-xl border px-4 py-2">
                    <option value="">Todas</option>
                    <option value="draft">Borrador</option>
                    <option value="open">Abierta</option>
                    <option value="hired">Contratada</option>
                    <option value="closed">Cerrada</option>
                </select>
            </div>

            @foreach ($offers as $offer)
                <div class="bg-white shadow-md rounded-2xl p-4 flex justify-between items-center hover:ring-2 hover:ring-indigo-300 transition">
                    <div>
                        <h2 class="font-bold text-lg text-purple-800">{{ $offer->title }}</h2>
                        <p class="text-sm text-gray-500">{{ $offer->category }} • {{ $offer->duration_unit }}{{ $offer->duration_quantity ? " ({$offer->duration_quantity})" : '' }}</p>
                        <p class="text-sm mt-1 text-gray-600 line-clamp-2">{{ Str::limit($offer->description, 100) }}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('offers.edit', $offer) }}" class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-xl">Editar</a>
                        <form action="{{ route('offers.destroy', $offer) }}" method="POST" onsubmit="return confirm('¿Eliminar oferta?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded-xl">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Detalle dinámico (a implementar con JS o Livewire si se desea) --}}
        <div class="lg:w-1/2 bg-white shadow-md rounded-2xl p-6 hidden lg:block">
            <p class="text-gray-500 text-center">Selecciona una oferta para ver los detalles aquí.</p>
        </div>
    </div>
@endsection
