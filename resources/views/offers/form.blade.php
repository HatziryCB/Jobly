@php
    $editing = isset($offer);
@endphp

<div class="bg-white max-w-5xl mx-auto mt-2 p-4 rounded-2xl shadow-2xl border border-gray-100 space-y-3">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
        {{ $editing ? 'Editar Oferta' : 'Crear Nueva Oferta' }}
    </h2>

    <div class="grid grid-cols-6 gap-2">
        {{-- Título --}}
        <div class="col-span-4">
            <x-input-label for="title" :value="'Título *'" />
                <x-text-input name="title" id="title" type="text" class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md" required maxlength="120"
                              :value="old('title', $offer->title ?? '')"/>
            <x-input-error :messages="$errors->get('title')" />
        </div>
        {{-- Categoría --}}
        <div class="col-span-2">
            <x-input-label for="category" :value="'Categoría *'" />
                <select name="category" id="category"
                        class="w-full border rounded-xl border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach([
                        'Limpieza','Pintura','Mudanza','Jardinería','Reparaciones',
                        'Electricidad','Plomería','Cuidado de niños','Cuidado de adultos mayores',
                        'Eventos','Mecánica','Construcción','Ayuda temporal','Asistencia'
                    ] as $cat)
                        <option value="{{ $cat }}" @selected(old('category', $offer->category ?? '') === $cat)>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            <x-input-error :messages="$errors->get('category')" />
        </div>
    </div>

    {{-- Descripción --}}
    <x-input-label for="description" :value="'Descripción *'" />
    <textarea name="description" id="description" rows="3"
              class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md" required>{{ old('description', $offer->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" />

    {{-- Requisitos + Duración --}}
    <div class="grid grid-cols-5 gap-4 pb-6">
        {{-- Requisitos (col-span-3) --}}
        <div class="col-span-3">
            <x-input-label for="requirements" :value="'Requisitos del trabajo'" />
            <textarea name="requirements" id="requirements" rows="5"
                      class="w-full h-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md">{{ old('requirements', $offer->requirements ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('requirements')" />
        </div>

        {{-- Duración y Cantidad --}}
        <div class="col-span-2 grid grid-cols-1 gap-2">
            <div x-data="{ unit: '{{ old('duration_unit', $offer->duration_unit ?? '') }}' }">
                <x-input-label for="duration_unit" :value="'Duración estimada *'"/>
                <select name="duration_unit" id="duration_unit"
                        x-model="unit"
                        class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md" required>
                    <option value="">Selecciona una unidad</option>
                    @foreach(['horas','días','semanas','meses','hasta finalizar'] as $unit)
                        <option value="{{ $unit }}"
                            @selected(old('duration_unit', $offer->duration_unit ?? '') === $unit)>
                            {{ ucfirst($unit) }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('duration_unit')" />
            </div>

            <div>
                <x-input-label for="duration_quantity" :value="'Cantidad'"/>
                <input type="number" min="1" name="duration_quantity" id="duration_quantity"
                       x-bind:disabled="unit === 'hasta finalizar'"
                       x-model="unit !== 'hasta finalizar' ? $refs.quantity.value : null"
                       x-ref="quantity"
                       :value="old('duration_quantity', $offer->duration_quantity ?? '')"
                       class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md">

                <x-input-error :messages="$errors->get('duration_quantity')" />
            </div>
        </div>
    </div>

    {{-- Dirección + Pagos --}}
    <div class="grid grid-cols-6 gap-2 mt-4">
        {{-- Dirección --}}
        <div class="col-span-4">
            <x-input-label for="location_text" :value="'Dirección del trabajo *'" />
            <input type="text" name="location_text" id="location_text"
                   class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md" required
                   placeholder="Ejemplo: 6a Calle 3-22, Barrio El Rastro, Puerto Barrios"
                   value="{{ old('location_text', $offer->location_text ?? '') }}">
            <x-input-error :messages="$errors->get('location_text')"/>
            {{-- Coordenadas ocultas --}}
            <input type="hidden" name="lat" id="lat" value="{{ old('lat', $offer->lat ?? '') }}">
            <input type="hidden" name="lng" id="lng" value="{{ old('lng', $offer->lng ?? '') }}">

            {{-- Mensaje de alerta si no hay permisos de ubicación --}}
            <div id="geo-alert" class="mt-2 hidden text-sm text-red-600">
                ⚠️ No se pudo obtener su ubicación. Asegúrate de permitir el acceso a la ubicación en tu navegador.
            </div>

        </div>
        {{-- Pago mínimo --}}
        <div class="col-span-1">
            <x-input-label for="pay_min" :value="'Pago mínimo (Q)'"/>
            <input type="number" name="pay_min" id="pay_min" min="0"
                   value="{{ old('pay_min', $offer->pay_min ?? '') }}"
                   class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md">
            <x-input-error :messages="$errors->get('pay_min')"/>
        </div>
        {{-- Pago máximo --}}
        <div class="col-span-1">
            <x-input-label for="pay_max" :value="'Pago máximo (Q)'" />
            <input type="number" name="pay_max" id="pay_max" min="0"
                   value="{{ old('pay_max', $offer->pay_max ?? '') }}"
                   class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md">
            <x-input-error :messages="$errors->get('pay_max')" />
        </div>
    </div>
    {{-- Estado --}}
    @if($editing)
        <x-input-label for="status" :value="'Estado'" />
        <select name="status" id="status"
                class="rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow hover:shadow-md">
            @foreach(['draft','open','hired','closed'] as $s)
                <option value="{{ $s }}" @selected(old('status', $offer->status ?? '') === $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" />
    @endif

    <p class="text-sm text-red-500">* Campos obligatorios</p>
    {{-- Botón --}}
    <div class="pb-2">
        <x-primary-button>{{ $submitLabel }}</x-primary-button>
    </div>
</div>

{{-- Script de geolocalización --}}
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');
            const geoAlert = document.getElementById('geo-alert');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        latInput.value = position.coords.latitude.toFixed(6);
                        lngInput.value = position.coords.longitude.toFixed(6);
                        console.log("Coordenadas detectadas:", latInput.value, lngInput.value);
                    },
                    function (error) {
                        console.error("Error al obtener ubicación:", error.message);
                        geoAlert.classList.remove('hidden');
                    }
                );
            } else {
                console.warn("Este navegador no soporta geolocalización");
                geoAlert.classList.remove('hidden');
            }
        });

    </script>
@endpush




