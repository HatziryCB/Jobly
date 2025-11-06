@extends('layouts.dashboard')

@section('title', 'Perfil de usuario')
@section('dashboard-content')
    @php
        $status = $profile->verification_status ?? 'none';
        $lock = $profile->lockLevel(); //  0 = sin verificación / 1 = solo identidad / 2 = identidad + residencia
        $u = $user ?? auth()->user();
        $hasPending = $u && $u->identityVerification && $u->identityVerification->status === 'pending';

        // Campos editables según nivel de verificación
        $canEditIdentity = $lock < 1;   // Si identidad verificada o pendiente → no editable
        $canEditLocation = $lock < 2;   // Si residencia verificada o pendiente → no editable
    @endphp

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Perfil</h2>

    {{-- Mensajes globales --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update', $profile->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- === FOTO Y ESTADO DE VERIFICACIÓN === --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('images/default-user.jpg') }}"
                     alt="Imagen de perfil"
                     class="w-24 h-24 rounded-full object-cover border mb-2">

                <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                       class="w-full rounded-xl border border-gray-300 focus:ring-indigo-200 transition-shadow mt-2">

                <x-input-error :messages="$errors->get('profile_picture')" />

                @if ($profile->profile_picture)
                    <div class="mt-2">
                        <input type="checkbox" name="remove_profile_picture" id="remove_profile_picture" value="1">
                        <label for="remove_profile_picture" class="text-sm text-red-500">Eliminar foto de perfil</label>
                    </div>
                @endif
            </div>

            {{-- Estado de verificación + botón --}}
            <div class="flex flex-col justify-center space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Estado de verificación:</p>
                    @if ($status === 'verified')
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                        <img src="{{ asset('images/verified-badge.png') }}" alt="Verificado" class="h-4 w-4"> Verificado
                    </span>
                    @elseif ($status === 'pending')
                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                        ⏳ En revisión
                    </span>
                    @elseif ($status === 'rejected')
                        <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                        ❌ Rechazado
                    </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                        ⚪ No verificado
                    </span>
                    @endif
                </div>
                {{-- Botón --}}
                <a href="{{ !$hasPending ? route('verification.create') : '#' }}"
                   @if($hasPending) aria-disabled="true" @endif
                   class="inline-flex w-fit items-center text-white text-sm rounded-full transition
                    {{ $hasPending ? 'bg-gray-400 cursor-not-allowed opacity-80 px-3 py-1' : 'bg-green-500 hover:bg-green-600 px-3 py-2' }}">
                    @if(!$hasPending)
                        <i class="fas fa-check-circle mr-1"></i>
                    @endif
                    {{ $hasPending ? 'Solicitud en revisión' : 'Solicitar verificación' }}
                </a>

            </div>

        </div>

        {{-- === DATOS PERSONALES === --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div>
                <x-input-label for="first_name" :value="'Primer nombre *'" />
                <x-text-input name="first_name" id="first_name"
                              :readonly="!$canEditIdentity"
                              class="w-full {{ !$canEditIdentity ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                              value="{{ old('first_name', $user->first_name) }}" required />
            </div>

            <div>
                <x-input-label for="second_name" :value="'Segundo nombre'" />
                <x-text-input name="second_name" id="second_name"
                              :readonly="!$canEditIdentity"
                              class="w-full {{ !$canEditIdentity ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                              value="{{ old('second_name', $user->second_name) }}" />
            </div>

            <div>
                <x-input-label for="last_name" :value="'Primer apellido *'" />
                <x-text-input name="last_name" id="last_name"
                              :readonly="!$canEditIdentity"
                              class="w-full {{ !$canEditIdentity ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                              value="{{ old('last_name', $user->last_name) }}" required />
            </div>

            <div>
                <x-input-label for="second_last_name" :value="'Segundo apellido'" />
                <x-text-input name="second_last_name" id="second_last_name"
                              :readonly="!$canEditIdentity"
                              class="w-full {{ !$canEditIdentity ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                              value="{{ old('second_last_name', $user->second_last_name) }}" />
            </div>

            <div>
                <x-input-label for="email" :value="'Correo electrónico *'" />
                <x-text-input id="email_display" type="email"
                              class="w-full bg-gray-100 cursor-not-allowed"
                              value="{{ $user->email }}" disabled />
            </div>
        </div>

        {{-- === RESTO DE CAMPOS === --}}
        @include('profile.partials._profile_form_fields', [
            'profile' => $profile,
            'user' => $user,
            'categories' => $categories,
            'canEditIdentity' => $canEditIdentity,
            'canEditLocation' => $canEditLocation,
        ])


        {{-- === BOTONES === --}}
        <div class="flex justify-end space-x-4 mt-4">
            <x-secondary-button onclick="window.location='{{ route('profile.show', $profile->user_id) }}'">
                Cancelar
            </x-secondary-button>
            <x-primary-button>Guardar</x-primary-button>
        </div>
    </form>
@endsection
