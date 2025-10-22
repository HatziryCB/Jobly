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

            <button type="submit" class="px-4 py-2 bg-[var(--brand-secondary)] transition text-white rounded-2xl">Filtrar</button>

            @auth
                @if(auth()->user()->hasRole('employer'))
                    <a href="{{ route('offers.create') }}" class="ml-auto text-sm text-blue-600 text- hover:underline">
                        + Nueva oferta
                    </a>
                @endif
            @endauth
        </form>

        {{-- Contenido principal --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Listado de ofertas (2 columnas) --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($offers as $offer)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-5 flex flex-col gap-2 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $offer->title }}</h3>
                            <span class="text-sm bg-blue-100 text-cyan-700 px-2 py-1 rounded-full">{{ $offer->category }}</span>
                        </div>

                        <p class="text-sm text-gray-600">{{ Str::limit($offer->description, 100) }}</p>

                        @if($offer->location_text)
                            <p class="text-sm text-gray-500"><i class="fa-solid fa-location-dot mr-1 text-amber-400 "></i>{{ $offer->location_text }}</p>
                        @endif

                        @if($offer->pay_min || $offer->pay_max)
                            <p class="text-sm text-gray-700">
                                <strong>Pago:</strong>
                                {{ $offer->pay_min ? 'Q' . number_format($offer->pay_min) : '' }}
                                {{ $offer->pay_max ? ' - Q' . number_format($offer->pay_max) : '' }}
                            </p>
                        @endif

                        <a href="{{ route('offers.show', $offer) }}"
                           class="mt-auto inline-block w-max px-4 py-2 text-sm font-medium text-white rounded-2xl bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] transition">
                            Ver detalles
                        </a>
                    </div>

                @endforeach

                <div class="mt-4">{{ $offers->links() }}</div>
            </div>

            {{-- Mapa --}}
            <div class="w-full mt-4 pointer-events-auto">
                <div id="map" class="w-full min-h-[400px] rounded-2xl shadow border" style="height: 500px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([15.7196, -88.5941], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            @foreach($offers as $offer)
            @if(!empty($offer->lat) && !empty($offer->lng))
            L.marker([{{ $offer->lat }}, {{ $offer->lng }}])
                .addTo(map)
                .bindPopup(`<strong>{{ $offer->title }}</strong><br>{{ $offer->location_text ?? 'Ubicación no disponible' }}`);
            @endif
            @endforeach
        });
    </script>
@endpush

