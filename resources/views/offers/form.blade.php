@php
    $editing = isset($offer);
@endphp

<div class="bg-white rounded-xl shadow-md p-6 space-y-4">

    {{-- Título --}}
    <x-input-label for="title" :value="'Título'" />
    <x-text-input name="title" id="title" type="text" class="w-full" required maxlength="120"
                  :value="old('title', $offer->title ?? '')"/>
    <x-input-error :messages="$errors->get('title')" />

    {{-- Descripción --}}
    <x-input-label for="description" :value="'Descripción'" />
    <textarea name="description" id="description" rows="4"
              class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300" required>{{ old('description', $offer->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" />

    {{-- Requisitos --}}
    <x-input-label for="requirements" :value="'Requisitos del trabajo'" />
    <textarea name="requirements" id="requirements" rows="3"
              class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">{{ old('requirements', $offer->requirements ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('requirements')" />

    {{-- Duración estimada --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="duration_unit" :value="'Duración estimada (unidad)'" />
            <select name="duration_unit" id="duration_unit"
                    class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
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

        <div x-data="{ unit: '{{ old('duration_unit', $offer->duration_unit ?? '') }}' }"
             x-init="$watch('unit', value => {
                const input = document.getElementById('duration_quantity');
                if (value === 'hasta finalizar') {
                    input.value = '';
                    input.disabled = true;
                } else {
                    input.disabled = false;
                }
            })">
            <x-input-label for="duration_quantity" :value="'Cantidad'" />
            <input type="number" min="1" name="duration_quantity" id="duration_quantity"
                   :disabled="old('duration_unit', $offer->duration_unit ?? '') === 'hasta finalizar'"
                   value="{{ old('duration_quantity', $offer->duration_quantity ?? '') }}"
                   class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            <x-input-error :messages="$errors->get('duration_quantity')" />
        </div>
    </div>

    {{-- Ubicación manual --}}
    <x-input-label for="location_text" :value="'Dirección del trabajo'" />
    <input type="text" name="location_text" id="location_text"
           class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300"
           value="{{ old('location_text', $offer->location_text ?? '') }}">
    <x-input-error :messages="$errors->get('location_text')" />

    {{-- Coordenadas ocultas --}}
    <input type="hidden" name="lat" id="lat" value="{{ old('lat', $offer->lat ?? '') }}">
    <input type="hidden" name="lng" id="lng" value="{{ old('lng', $offer->lng ?? '') }}">

    {{-- Categoría --}}
    <x-input-label for="category" :value="'Categoría'" />
    <select name="category" id="category"
            class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
        <option value="">Selecciona una categoría</option>
        @foreach(['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería','Otros'] as $cat)
            <option value="{{ $cat }}" @selected(old('category', $offer->category ?? '') === $cat)>
                {{ $cat }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category')" />

    {{-- Pago mínimo y máximo --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="pay_min" :value="'Pago mínimo (Q)'" />
            <input type="number" name="pay_min" id="pay_min" min="0"
                   value="{{ old('pay_min', $offer->pay_min ?? '') }}"
                   class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            <x-input-error :messages="$errors->get('pay_min')" />
        </div>

        <div>
            <x-input-label for="pay_max" :value="'Pago máximo (Q)'" />
            <input type="number" name="pay_max" id="pay_max" min="0"
                   value="{{ old('pay_max', $offer->pay_max ?? '') }}"
                   class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            <x-input-error :messages="$errors->get('pay_max')" />
        </div>
    </div>

    {{-- Estado (solo en edición) --}}
    @if($editing)
        <x-input-label for="status" :value="'Estado'" />
        <select name="status" id="status" class="w-full rounded-md border-gray-300">
            @foreach(['draft','open','hired','closed'] as $s)
                <option value="{{ $s }}" @selected(old('status', $offer->status ?? '') === $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" />
    @endif

    {{-- Botón --}}
    <div class="pt-4">
        <x-primary-button>{{ $submitLabel }}</x-primary-button>
    </div>

</div>

@push('scripts')
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat').value = position.coords.latitude.toFixed(6);
                document.getElementById('lng').value = position.coords.longitude.toFixed(6);
            });
        }
    </script>
@endpush
