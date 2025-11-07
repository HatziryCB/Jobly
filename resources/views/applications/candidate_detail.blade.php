@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div class="flex items-center gap-6">
                @php
                    $profile = auth()->user()->profile;
                @endphp

                <img src="{{ $profile && $profile->profile_picture
                            ? asset('storage/' . $profile->profile_picture)
                            : asset('images/default-user.jpg') }}"
                             alt="Foto de perfil"
                             class="w-20 h-20 rounded-full object-cover border mx-auto" />
                <div>
                    <x-verification-badge
                        :status="$application->employee->verification_status"
                        :firstName="$application->employee->first_name"
                        :lastName="$application->employee->last_name"
                    />
                    <div class="text-sm text-gray-600">{{ $application->employee->profile->municipality ?? 'Ubicación no disponible' }}</div>
                    <div class="text-sm text-yellow-500 flex items-center mt-1">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fas fa-star{{ $i < ($application->employee->profile->average_rating ?? 0) ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            <div>
                <form action="{{ route('applications.accept', $application->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Aceptar Candidato
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-gray-700">Mensaje de postulación</h3>
                <p class="text-gray-600">{{ $application->message ?? 'Sin mensaje' }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700">Verificación</h3>
                <p class="text-gray-600">
                    @if ($application->employee->profile->is_verified)
                        <span class="text-green-600 font-medium">Verificado</span>
                    @else
                        <span class="text-red-500 font-medium">No verificado</span>
                    @endif
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700">Categorías</h3>
                <p class="text-gray-600">
                    {{ implode(', ', $application->employee->profile->work_categories ?? []) }}
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700">Descripción personal</h3>
                <p class="text-gray-600">{{ $application->employee->profile->bio ?? 'No disponible' }}</p>
            </div>
        </div>

        <form action="#" method="GET">
            <button type="submit" class="mt-6 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                Contactar por Chat
            </button>
        </form>
    </div>
@endsection
