@extends('layouts.app')

@section('title', 'Ofertas disponibles')

@section('content')
    <div class="py-6 px-4 max-w-screen-2xl mx-auto">

        @if (session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        {{-- Filtros y buscador --}}
        <form method="GET" action="{{ route('offers.index') }}" class="flex flex-wrap md:flex-nowrap items-center gap-4 mb-4">
            <input type="text" name="q" placeholder="Buscar por título o descripción" value="{{ $q ?? '' }}"
                   class="flex-1 rounded-2xl border-gray-300 shadow-sm">

            <select name="category" class="rounded-2xl border-gray-300">
                <option value="">Todas las categorías</option>
                @foreach(['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería'] as $cat)
                    <option value="{{ $cat }}" @selected(request('category') == $cat)>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-2xl transition">Filtrar</button>

            @auth
                @if(auth()->user()->hasRole('employer'))
                    <a href="{{ route('offers.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-2xl transition">
                        Nueva oferta
                    </a>
                @endif
            @endauth
        </form>

        {{-- Contenedor principal de contenido --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Columna izquierda: Ofertas --}}
            <div class="lg:col-span-2 space-y-4">
                @forelse($offers as $offer)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-5 flex flex-col gap-2 hover:shadow-lg transition relative">
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
                            {{-- Etiqueta categoría --}}
                            <span class="px-3 py-1 right-4 top-4 absolute rounded-full text-xs font-semibold {{ $color }}">
                            {{ $offer->category }}
                            </span>
                        {{-- Título --}}
                        <h3 class="text-xl font-bold text-gray-800">{{ $offer->title }}</h3>

                        {{-- Descripción breve --}}
                        <p class="text-lg text-gray-600">{{ Str::limit($offer->description, 100) }}</p>

                        {{-- Ubicación --}}
                        <div class="flex items-center gap-2 text-m text-gray-700">
                            <i class="fa-solid fa-location-dot text-pink-500"></i>
                            {{ $offer->location_text ?? 'No especificada' }}
                        </div>

                        {{-- Pago --}}
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <i class="fa-solid fa-money-bill-wave text-green-500"></i>
                            @if($offer->pay_min || $offer->pay_max)
                                Q{{ number_format($offer->pay_min) ?? '—' }} - Q{{ number_format($offer->pay_max) ?? '—' }}
                            @else
                                No definido
                            @endif
                        </div>

                        {{-- Duración --}}
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <i class="fa-solid fa-clock text-yellow-400"></i>
                            @if($offer->duration_unit === 'hasta finalizar')
                                Hasta finalizar
                            @else
                                {{ $offer->duration_quantity }} {{ $offer->duration_unit }}
                            @endif
                        </div>

                        {{-- Botón --}}
                        <div class="mt-auto">
                            <a href="{{ route('offers.show', $offer) }}"
                               class="inline-block mt-1 px-2 py-2 text-sm font-sm text-gray-600 bg-sky-400 hover:bg-indigo-500 rounded-2xl transition">
                                Ver detalles
                            </a>
                            @if ($offer->lat && $offer->lng)
                                <button
                                    onclick="focusMap({ lat: {{ $offer->lat }}, lng: {{ $offer->lng }} })"
                                    class="inline-block mt-1 px-2 py-2 text-sm font-sm text-purple-800 bg-purple-200 hover:bg-indigo-500 rounded-2xl transition">
                                    Ver en mapa
                                </button>
                            @endif

                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">No se encontraron ofertas.</p>
                @endforelse
            </div>

            {{-- Columna derecha: Mapa --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div id="map" class="w-full h-[550px] rounded-2xl shadow border z-map"></div>
                </div>
            </div>
        </div>

        {{-- Paginación --}}
        <div class="mt-6">{{ $offers->links() }}</div>
    </div>
@endsection

@push('scripts')
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlapping-marker-spiderfier-leaflet@1.0.3/oms.min.js"></script>

    <script>
        let mapInstance;

        document.addEventListener('DOMContentLoaded', function () {
            const offers = @json($offersForMap);
            mapInstance = L.map('map').setView([15.7196, -88.5941], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapInstance);

            offers.forEach(offer => {
                if (offer.lat && offer.lng) {
                    L.marker([offer.lat, offer.lng]).addTo(mapInstance)
                        .bindPopup(`<strong>${offer.title}</strong><br>${offer.location_text}<br><a href='/offers/${offer.id}'>Ver detalles</a>`);
                }
            });
        });

        function focusMap({ lat, lng }) {
            if (mapInstance) {
                mapInstance.setView([lat, lng], 15);
            }
        }

    </script>
@endpush
