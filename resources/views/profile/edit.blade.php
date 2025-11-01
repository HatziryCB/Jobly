@extends('layouts.dashboard')

@section('title', 'Perfil de usuario')
@section('dashboard-content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Perfil</h2>

    <form method="POST" action="{{ route('profile.update', $profile->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- === FOTO DE PERFIL === --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input-label for="profile_picture" :value="'Foto de Perfil'" />
                <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('images/default-user.jpg') }}"
                     alt="Imagen de perfil"
                     class="w-24 h-24 rounded-full object-cover border">

                <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                       class="w-full rounded-2xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow mt-2">

                <x-input-error :messages="$errors->get('profile_picture')" />

                @if ($profile->profile_picture)
                    <div class="mt-2">
                        <input type="checkbox" name="remove_profile_picture" id="remove_profile_picture" value="1">
                        <label for="remove_profile_picture" class="text-sm text-red-500">Eliminar foto de perfil</label>
                    </div>
                @endif
            </div>

            {{-- === ESTADO DE VERIFICACIÓN === --}}
            <div class="flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-m font-medium text-gray-700">Estado de Verificación:</p>
                        <p class="text-sm font-semibold
                            {{ $profile->verification_status === 'verified' ? 'text-green-600' : ($profile->verification_status === 'rejected' ? 'text-red-500' : 'text-yellow-600') }}">
                            {{ ucfirst($profile->verification_status_label) }}
                        </p>
                    </div>
                    <button type="button" class="bg-sky-500 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded-2xl">
                        Solicitar Verificación
                    </button>
                </div>
            </div>
        </div>

        {{-- === DATOS PERSONALES (User) === --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            {{-- Primer nombre --}}
            <div>
                <x-input-label for="first_name" :value="'Primer nombre *'" />
                <x-text-input id="first_name_display" type="text" class="w-full bg-gray-100"
                              value="{{ $user->first_name }}" disabled />
                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
            </div>

            {{-- Segundo nombre --}}
            <div>
                <x-input-label for="second_name" :value="'Segundo nombre'" />
                <x-text-input name="second_name" id="second_name" type="text" class="w-full"
                              :value="old('second_name', $user->second_name)" />
            </div>

            {{-- Primer apellido --}}
            <div>
                <x-input-label for="last_name" :value="'Primer apellido *'" />
                <x-text-input id="last_name_display" type="text" class="w-full bg-gray-100"
                              value="{{ $user->last_name }}" disabled />
                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
            </div>

            {{-- Segundo apellido --}}
            <div>
                <x-input-label for="second_last_name" :value="'Segundo apellido'" />
                <x-text-input name="second_last_name" id="second_last_name" type="text" class="w-full"
                              :value="old('second_last_name', $user->second_last_name)" />
            </div>

            {{-- Correo electrónico --}}
            <div>
                <x-input-label for="email" :value="'Correo electrónico *'" />
                <x-text-input id="email_display" type="email" class="w-full bg-gray-100"
                              value="{{ $user->email }}" disabled />
                <input type="hidden" name="email" value="{{ $user->email }}">
            </div>
        </div>

        {{-- === CATEGORÍAS === --}}
        <div>
            <label class="block text-sm font-medium mb-2">Categorías de trabajo de interés:</label>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                @foreach ($categories as $category)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="work_categories[]" value="{{ $category }}"
                               @if (in_array($category, $profile->work_categories ?? [])) checked @endif
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span>{{ $category }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- === BIO Y EXPERIENCIA === --}}
        <div>
            <x-input-label for="bio" :value="'Descripción personal *'" />
            <textarea name="bio" id="bio" rows="3"
                      class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow" required>{{ old('bio', $profile->bio) }}</textarea>
            <x-input-error :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="experience" :value="'Experiencia laboral *'" />
            <textarea name="experience" id="experience" rows="4"
                      class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow" required>{{ old('experience', $profile->experience) }}</textarea>
            <x-input-error :messages="$errors->get('experience')" />
        </div>

        {{-- === UBICACIÓN Y OTROS === --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div>
                <x-input-label for="department" :value="'Departamento *'" />
                <x-text-input name="department" id="department" type="text" class="w-full"
                              :value="old('department', $profile->department)" required />
            </div>
            <div>
                <x-input-label for="municipality" :value="'Municipio *'" />
                <x-text-input name="municipality" id="municipality" type="text" class="w-full"
                              :value="old('municipality', $profile->municipality)" required />
            </div>
            <div>
                <x-input-label for="zone" :value="'Zona'" />
                <x-text-input name="zone" id="zone" type="text" class="w-full"
                              :value="old('zone', $profile->zone)" />
            </div>
            <div>
                <x-input-label for="neighborhood" :value="'Colonia / Aldea / Barrio'" />
                <x-text-input name="neighborhood" id="neighborhood" type="text" class="w-full"
                              :value="old('neighborhood', $profile->neighborhood)" />
            </div>
            <div>
                <x-input-label for="phone" :value="'Teléfono'" />
                <x-text-input name="phone" id="phone" type="text" class="w-full"
                              :value="old('phone', $user->phone)" />
            </div>
        </div>

        {{-- === NACIMIENTO Y GÉNERO === --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div>
                <x-input-label for="birth_date" :value="'Fecha de nacimiento *'" />
                <x-text-input type="date" name="birth_date" id="birth_date" class="w-full"
                              value="{{ old('birth_date', $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('Y-m-d') : '') }}" required />
                <x-input-error :messages="$errors->get('birth_date')" />
            </div>

            <div>
                <x-input-label for="gender" :value="'Género *'" />
                <select name="gender" id="gender" class="w-full rounded-xl border border-gray-300 focus:border-indigo-400">
                    <option value="">Seleccione</option>
                    <option value="male" @selected(old('gender', $profile->gender) === 'male')>Masculino</option>
                    <option value="female" @selected(old('gender', $profile->gender) === 'female')>Femenino</option>
                    <option value="other" @selected(old('gender', $profile->gender) === 'other')>Otro</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" />
            </div>
        </div>

        {{-- === BOTONES === --}}
        <div class="flex justify-end space-x-4 mt-4">
            <x-secondary-button onclick="window.location='{{ route('profile.show', $profile->user_id) }}'">
                Cancelar
            </x-secondary-button>
            <x-primary-button>Guardar</x-primary-button>
        </div>
    </form>
@endsection
