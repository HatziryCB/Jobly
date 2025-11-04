@extends('layouts.dashboard')
@section('title', 'Verificación de identidad')

@section('dashboard-content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Verificación de identidad</h2>

    <p class="text-gray-600 mb-6">
        Completa los siguientes campos y adjunta tus documentos. Esta información será revisada manualmente
        por nuestro equipo para validar tu identidad.
    </p>

    <form method="POST" action="{{ route('verification.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nombres --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Primer nombre</label>
                <input type="text" value="{{ $user->first_name }}" disabled class="w-full bg-gray-100 rounded-xl border-gray-300" />
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Segundo nombre</label>
                <input type="text" value="{{ $user->second_name }}" disabled class="w-full bg-gray-100 rounded-xl border-gray-300" />
            </div>

            {{-- Apellidos --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Primer apellido</label>
                <input type="text" value="{{ $user->last_name }}" disabled class="w-full bg-gray-100 rounded-xl border-gray-300" />
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Segundo apellido</label>
                <input type="text" value="{{ $user->second_last_name }}" disabled class="w-full bg-gray-100 rounded-xl border-gray-300" />
            </div>

            {{-- DPI --}}
            <div>
                <label for="dpi" class="block font-medium text-sm text-gray-700">Número de DPI *</label>
                <input type="text" name="dpi" id="dpi" value="{{ old('dpi') }}"
                       class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                @error('dpi')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Fecha de nacimiento --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Fecha de nacimiento</label>
                <input type="date" value="{{ $profile->birth_date }}" disabled class="w-full bg-gray-100 rounded-xl border-gray-300" />
            </div>
        </div>

        {{-- Archivos --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="dpi_front" class="block text-sm font-medium">DPI (frontal)</label>
                <input type="file" name="dpi_front" id="dpi_front" accept="image/*"
                       class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label for="dpi_back" class="block text-sm font-medium">DPI (trasera)</label>
                <input type="file" name="dpi_back" id="dpi_back" accept="image/*"
                       class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label for="selfie_with_dpi" class="block text-sm font-medium">Selfie con DPI</label>
                <input type="file" name="selfie_with_dpi" id="selfie_with_dpi" accept="image/*"
                       class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label for="proof_of_address" class="block text-sm font-medium">Comprobante de domicilio</label>
                <input type="file" name="proof_of_address" id="proof_of_address" accept="image/*"
                       class="w-full rounded-xl border-gray-300">
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-4">
            <x-secondary-button onclick="window.location='{{ route('profile.show', $user->id) }}'">Cancelar</x-secondary-button>
            <x-primary-button>Enviar solicitud</x-primary-button>
        </div>
    </form>
@endsection

