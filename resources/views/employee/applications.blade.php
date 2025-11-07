@extends('layouts.dashboard')

@section('dashboard-content')
    <h2 class="text-2xl font-bold mb-4">Mis Postulaciones</h2>
    <div class="mb-6">
        {{-- Encabezado y Barra de Búsqueda/Filtros --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <form method="GET" action="{{ route('employee.applications') }}" class="flex flex-wrap lg:flex-nowrap items-center gap-3">

                {{-- Buscador (q) --}}
                <input type="text" name="q" placeholder="Buscar oferta..." value="{{ $q ?? '' }}"
                       class="rounded-xl border border-gray-300 px-4 py-2 w-full lg:w-64 focus:ring-2 focus:ring-indigo-300">

                {{-- Filtro de Estado (status) --}}
                <select name="status" class="rounded-xl border border-gray-300 px-8 py-2 focus:ring-indigo-300 w-full lg:w-auto">
                    <option value="">Todos los estados</option>
                    {{-- Usamos $status para mantener la selección --}}
                    <option value="draft" @selected(($status ?? request('status')) === 'draft')>Borrador</option>
                    <option value="open" @selected(($status ?? request('status')) === 'open')>Abierta</option>
                    <option value="hired" @selected(($status ?? request('status')) === 'hired')>Contratada</option>
                    <option value="closed" @selected(($status ?? request('status')) === 'closed')>Cerrada</option>
                </select>

                {{-- Filtro de Categoría  --}}
                <select name="category" class="rounded-xl border border-gray-300 px-8 py-2 focus:ring-indigo-300 w-full lg:w-auto">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected((request('category')) === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>

                <button class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition w-full lg:w-auto flex-shrink-0">
                    <i class="fa-solid fa-search mr-1"></i> Buscar
                </button>

                {{-- Botón para Limpiar Filtros --}}
                @if ($q || $status || $category)
                    <a href="{{ route('employee.applications') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl transition w-full lg:w-auto text-center flex-shrink-0">
                        <i class="fa-solid fa-xmark mr-1"></i> Limpiar
                    </a>
                @endif
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
        @forelse ($applications as $application)

            <div class="border rounded-2xl p-4 shadow-sm bg-white">
                <h3 class="font-semibold text-xl">{{ $application->offer->title }}</h3>
                <p> <i class="fas fa-map-marker-alt mr-2 text-purple-500"></i>{{ $application->offer->location_text }}</p>
                    <p class="text-sm"><i class="fas fa-clock text-yellow-400 mr-2"></i>
                        @if($application->offer->duration_unit === 'hasta finalizar')
                            Hasta finalizar
                        @else
                            {{ $application->offer->duration_quantity }} {{ $application->offer->duration_unit }}
                        @endif
                    </p>
                <p class="text-sm mb-4">
                    <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
                    Q{{ $application->offer->pay_min }} - Q{{ $application->offer->pay_max }}
                </p>
                {{-- Etiquetas de Categoría --}}
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
                    $color = $colors[$application->offer->category] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="px-2 py-2 mt-5 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $application->offer->category }}
                </span>
                <p class="text-m mt-2 text-gray-800">Descripción</p>
                <p class="text-m text-gray-700 mt-2 line-clamp-4">{{ Str::limit($application->offer->description, 300) }}</p>
                <p class="text-m mt-2 text-gray-800">Mensaje:</p>
                <p class="text-gray-500 text-sm line-clamp-4 mt-1">{{ $application->message ?? 'No haz dejado mensaje' }}</p>
                <p class="text-sm text-cyan-500 mt-1">Estado: {{ ucfirst($application->offer->status) }}</p>
                <div class="flex justify-between items-center mt-5">
                    <div>
                    <div class="flex gap-5">
                        <a href="{{ route('offers.show', $application->offer->id) }}"
                           class="bg-indigo-500 text-white px-2 py-2 rounded-xl text-sm font-medium hover:bg-indigo-600 transition-colors flex-shrink-0">
                            Ver oferta
                        </a>
                    </div>
                </div>
                </div>
            </div>
        @empty
            <p>No tienes postulaciones aún.</p>
        @endforelse
    </div>
    <div class="mt-6 flex justify-end">
        {{ $applications->links() }}
    </div>
@endsection
