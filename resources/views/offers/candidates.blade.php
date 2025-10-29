@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="flex flex-col md:flex-row gap-4">
        {{-- Lista de candidatos a la izquierda --}}
        <div class="w-full md:w-1/3 space-y-4">
            @forelse ($candidates as $candidate)
                <div class="bg-white rounded-2xl shadow p-4 cursor-pointer hover:shadow-md transition" onclick="window.location='{{ route('candidates.show', $candidate->id) }}'">
                    <div class="flex items-center gap-4">
                        <img src="{{ $candidate->profile_photo_url ?? '/images/default-profile.png' }}" class="w-16 h-16 rounded-full object-cover border border-gray-300">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">{{ $candidate->user->first_name }} {{ $candidate->user->last_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $candidate->user->location_text ?? 'Ubicación no disponible' }}</p>
                            <div class="text-sm text-yellow-500 flex items-center">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star{{ $i < $candidate->user->average_rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No hay candidatos aún.</p>
            @endforelse
        </div>

        {{-- Detalle del candidato a la derecha --}}
        <div class="w-full md:w-2/3">
            @isset($selectedCandidate)
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center gap-6 border-b pb-4 mb-4">
                        <img src="{{ $selectedCandidate->profile_photo_url ?? '/images/default-profile.png' }}" class="w-24 h-24 rounded-full object-cover border">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $selectedCandidate->user->first_name }} {{ $selectedCandidate->user->last_name }}</h2>
                            <div class="text-sm text-gray-600">{{ $selectedCandidate->user->location_text ?? 'Ubicación no disponible' }}</div>
                            <div class="text-sm text-yellow-500 flex items-center">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star{{ $i < $selectedCandidate->user->average_rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-700">Experiencia</h3>
                            <p class="text-gray-600">{{ $selectedCandidate->experience ?? 'No disponible' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Categorías</h3>
                            <p class="text-gray-600">{{ $selectedCandidate->categories ?? 'No asignadas' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Descripción personal</h3>
                            <p class="text-gray-600">{{ $selectedCandidate->bio ?? 'No disponible' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Verificación</h3>
                            <p class="text-gray-600">
                                @if ($selectedCandidate->is_verified)
                                    <span class="text-green-600 font-medium">Verificado</span>
                                @else
                                    <span class="text-red-500 font-medium">No verificado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection
