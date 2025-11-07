@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Columna izquierda - resumen --}}
        <div class="lg:w-1/3 bg-white p-6 rounded-xl shadow space-y-6">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" @click="show = false"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Foto y datos principales --}}
            <div class="text-center">
                <img src="{{ $user->profile->profile_picture ? asset('storage/' . $user->profile->profile_picture) : asset('images/default-user.jpg') }}"
                     class="w-24 h-24 rounded-full mx-auto mt-5 mb-6 object-cover border shadow-sm">

                <div class="text-center mt-2">
                    <x-verification-badge
                        :status="$user->profile->verification_status"
                        :firstName="$user->first_name"
                        :lastName="$user->last_name"
                        layout="center"
                    />
                    <x-verification-badge-label :status="$user->profile->verification_status" />
                </div>

                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            </div>

            {{-- Datos básicos --}}
            <div class="space-y-2 mb-5 text-sm text-gray-700">
                <p><i class="fas fa-phone mr-2 text-amber-500"></i>{{ $user->phone ?? 'No especificado' }}</p>
                <p><i class="fas fa-calendar-alt mr-2 text-sky-500"></i>
                    {{ $user->profile->birth_date ? \Carbon\Carbon::parse($user->profile->birth_date)->format('d/m/Y') : 'No especificado' }}
                </p>
                @php
                    $generos = [
                        'male' => 'Masculino',
                        'female' => 'Femenino',
                        'other' => 'Otro',
                        'unspecified' => 'No especificado'
                    ];
                @endphp
                <p><i class="fas fa-venus-mars mr-2 text-purple-500"></i>{{ $generos[$user->profile->gender] ?? 'No especificado' }}</p>

                {{-- Dirección limpia y condicional --}}
                <p class="flex items-start">
                    <i class="fas fa-map-marker-alt mr-2 text-rose-500 mt-1"></i>
                    <span>
                    {{ $user->profile->municipality ?? 'Municipio no especificado' }},
                    {{ $user->profile->department ?? 'Departamento no especificado' }}
                        @if ($user->profile->zone)
                            , zona {{ $user->profile->zone }}
                        @endif
                        @if ($user->profile->neighborhood)
                            , {{ $user->profile->neighborhood }}
                        @endif
                </span>
                </p>

                {{-- Estado de verificaciones --}}
                <div class="mt-4 space-y-1">
                    <p class="text-gray-700 font-medium">
                        <i class="fas fa-id-card text-emerald-500 mr-2"></i>
                        Identidad:
                        @if ($user->profile->verification_status === 'verified')
                            <span class="text-green-600 font-semibold">Verificada</span>
                        @elseif ($user->profile->verification_status === 'pending')
                            <span class="text-yellow-600 font-semibold">En revisión</span>
                        @elseif ($user->profile->verification_status === 'rejected')
                            <span class="text-red-600 font-semibold">Rechazada</span>
                        @else
                            <span class="text-gray-500">No verificada</span>
                        @endif
                    </p>

                    {{-- Si el usuario tiene comprobante validado --}}
                    @if ($user->verification && $user->verification->voucher)
                        <p class="text-gray-700 font-medium">
                            <i class="fas fa-map-pin text-indigo-500 mr-2"></i>
                            Ubicación: <span class="text-green-600 font-semibold">Verificada</span>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('profile.edit', $user->id) }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 text-sm">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>

                @php
                    $status = $user->profile->verification_status;
                @endphp

                @if ($status !== 'pending')
                @role('employee|employer')
                <a href="{{ route('verification.create') }}"
                   class="px-3 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 text-sm">
                    <i class="fas fa-check-circle mr-1"></i> Solicitar verificación
                </a>
                @endrole
                @endif
            </div>

        </div>

        {{-- Columna derecha - información detallada --}}
        <div class="lg:w-2/3 bg-white p-6 rounded-xl shadow space-y-6">

            <div>
                <h3 class="font-semibold text-lg mb-2">Biografía</h3>
                <p class="text-gray-700">{{ $user->profile->bio ?? 'Sin descripción aún.' }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Experiencia</h3>
                <p class="text-gray-700">{{ $user->profile->experience ?? 'No registrada.' }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Categorías de trabajo</h3>
                @if(!empty($user->profile->work_categories))
                    @foreach($user->profile->work_categories as $cat)
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full mr-2">{{ $cat }}</span>
                    @endforeach
                @else
                    <p class="text-gray-500">No seleccionadas.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
