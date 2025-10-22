@php
    $editing = isset($offer);
@endphp

<div class="bg-white rounded-xl shadow-md p-6 space-y-4">
    <div>
        <label for="title" class="block text-sm font-semibold mb-1">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title', $offer->title ?? '') }}" required
               class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300" maxlength="120">
        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-semibold mb-1">Descripción</label>
        <textarea name="description" id="description" rows="4" required
                  class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">{{ old('description', $offer->description ?? '') }}</textarea>
        @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="location_text" class="block text-sm font-semibold mb-1">Ubicación</label>
        <input type="text" name="location_text" id="location_text" value="{{ old('location_text', $offer->location_text ?? '') }}"
               readonly class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-700">
    </div>

    <input type="hidden" name="lat" id="lat" value="{{ old('lat', $offer->lat ?? '') }}">
    <input type="hidden" name="lng" id="lng" value="{{ old('lng', $offer->lng ?? '') }}">

    <div>
        <label for="category" class="block text-sm font-semibold mb-1">Categoría</label>
        <select name="category" id="category" required
                class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            <option value="" disabled {{ old('category', $offer->category ?? '') === '' ? 'selected' : '' }}>
                Selecciona una categoría
            </option>
            @foreach(['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $offer->category ?? '') === $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>
        @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="pay_min" class="block text-sm font-semibold mb-1">Pago mínimo (Q)</label>
            <input type="number" name="pay_min" id="pay_min" min="0"
                   value="{{ old('pay_min', $offer->pay_min ?? '') }}"
                   class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            @error('pay_min') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="pay_max" class="block text-sm font-semibold mb-1">Pago máximo (Q)</label>
            <input type="number" name="pay_max" id="pay_max" min="0"
                   value="{{ old('pay_max', $offer->pay_max ?? '') }}"
                   class="w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-300">
            @error('pay_max') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    @if($editing)
        <div>
            <label for="status" class="block text-sm font-semibold mb-1">Estado</label>
            <select name="status" id="status" class="w-full rounded-md border-gray-300">
                @foreach(['draft','open','hired','closed'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $offer->status ?? '') === $s)>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    @endif

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

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('location_text').value = data.display_name;
                    })
                    .catch(error => console.error("Error al obtener dirección:", error));
            });
        }
    </script>
@endpush
