{{-- Formulario reutilizable para crear o editar ofertas --}}
@php
    /** @var \App\Models\Offer|null $offer */
@endphp

<div class="mb-3">
    <label class="form-label">Título</label>
    <input name="title" class="form-control"
           value="{{ old('title', $offer->title ?? '') }}" required maxlength="120">
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control" rows="5" required>{{ old('description', $offer->description ?? '') }}</textarea>
    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Ubicación (texto)</label>
    <input name="location_text" class="form-control"
           value="{{ old('location_text', $offer->location_text ?? '') }}" maxlength="120">
    @error('location_text') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row mb-3">
    <div class="col">
        <label class="form-label">Pago mínimo (Q)</label>
        <input type="number" name="pay_min" class="form-control"
               value="{{ old('pay_min', $offer->pay_min ?? '') }}" min="0">
        @error('pay_min') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col">
        <label class="form-label">Pago máximo (Q)</label>
        <input type="number" name="pay_max" class="form-control"
               value="{{ old('pay_max', $offer->pay_max ?? '') }}" min="0">
        @error('pay_max') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

@if(isset($offer))
    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select">
            @foreach (['draft'=>'Borrador','open'=>'Abierta','hired'=>'Contratada','closed'=>'Cerrada'] as $val=>$label)
                <option value="{{ $val }}" {{ old('status', $offer->status) === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
@endif

<div class="d-flex gap-2">
    <button class="btn btn-primary">{{ $submitLabel ?? 'Guardar' }}</button>
    <a href="{{ route('offers.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
