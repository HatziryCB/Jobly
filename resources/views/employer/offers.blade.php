@extends('layouts.dashboard')

@section('title', 'Mis Ofertas')

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">Mis Ofertas</h2>
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" placeholder="Buscar oferta..." value="{{ request('q') }}"
                   class="rounded-xl border border-gray-300 px-4 py-2 w-64 focus:ring-2 focus:ring-indigo-300">
            <select name="status" class="rounded-xl border border-gray-300 px-8 py-2 focus:ring-indigo-300">
                <option value="">Todos los estados</option>
                <option value="draft" @selected(request('status')==='draft')>Borrador</option>
                <option value="open" @selected(request('status')==='open')>Abierta</option>
                <option value="hired" @selected(request('status')==='hired')>Contratada</option>
                <option value="closed" @selected(request('status')==='closed')>Cerrada</option>
            </select>
            <select name="category" class="rounded-xl border border-gray-300 px-8 py-2 focus:ring-indigo-300">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
                @endforeach
            </select>
            <button class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    @if ($offers->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg text-center">
            No tienes ofertas publicadas aún.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4">
            @foreach ($offers as $offer)
                <div class="relative bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between h-64 hover:shadow-lg transition-all duration-200">
                    <div>
                        @if ($offer->applications_count > 0)
                            <span class="absolute top-3 right-3 bg-yellow-200 text-yellow-600 text-xs font-semibold px-2.5 py-0.5 rounded-2xl shadow">
                                {{ $offer->applications_count }} postulante{{ $offer->applications_count > 1 ? 's' : '' }}
                            </span>
                        @endif
                        <h3 class="text-lg font-semibold text-indigo-700">{{ $offer->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-6">{{ Str::limit($offer->description, 300) }}</p>

                        <div class="mt-2 flex items-center gap-2">
                            {{-- Categoría con color --}}
                            @php
                                $colors = [
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
                                ];
                                $color = $colors[$offer->category] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                            {{ $offer->category }}
                            </span>

                            {{-- Estado --}}
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $offer->status === 'open' ? 'bg-green-100 text-green-700' :
                                ($offer->status === 'draft' ? 'bg-gray-100 text-gray-700' :
                                ($offer->status === 'hired' ? 'bg-blue-100 text-blue-700' :
                                'bg-red-100 text-red-700')) }}">
                            {{ ucfirst($offer->status) }}
                        </span>
                        </div>
                    </div>

                    {{-- Pago y acciones --}}
                    <div class="flex justify-between items-center mt-4">
                        <p class="text-green-600 font-semibold">
                            Q{{ $offer->pay_min ?? 0 }} - Q{{ $offer->pay_max ?? 0 }}
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('applications.candidates', $offer->id) }}" class="bg-blue-400 hover:bg-blue-500 text-white px-2 py-1 rounded-2xl text-xs">
                                Ver candidatos
                            </a>
                            <a href="{{ route('offers.show', $offer) }}" class="text-indigo-300 hover:text-indigo-400">
                                <i class="fa-regular fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('offers.edit', $offer) }}" class="text-yellow-300 hover:text-yellow-400">
                                <i class="fa-regular fa-pen-to-square text-lg"></i>
                            </a>
                            <form method="POST" action="{{ route('offers.destroy', $offer) }}"
                                  onsubmit="return confirm('¿Eliminar oferta?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-300 hover:text-red-400">
                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $offers->links() }}
        </div>
    @endif
@endsection
