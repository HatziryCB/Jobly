@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="flex flex-col md:flex-row gap-4">
        {{-- Lista de candidatos a la izquierda --}}
        <div class="w-full md:w-1/3 space-y-4 overflow-y-auto max-h-[70vh] pr-2">
            @forelse ($candidates as $candidate)
                <div class="bg-white rounded-2xl shadow p-4 cursor-pointer hover:shadow-md transition"
                     onclick="window.location='{{ route('offers.candidates.show', [$offer->id, $candidate->employee_id]) }}'">
                    <div class="flex items-center gap-4">
                        @php
                            $profile = auth()->user()->profile;
                        @endphp

                        <img src="{{ $profile && $profile->profile_picture
                                    ? asset('storage/' . $profile->profile_picture)
                                    : asset('images/default-user.jpg') }}"
                                     alt="Foto de perfil"
                                     class="w-20 h-20 rounded-full object-cover border" />
                        <div>
                            <p class="text-gray-700 font-semibold flex items-center gap-2">
                                {{ $candidate->employee->first_name }} {{ $candidate->employee->last_name }}
                                @if ($candidate->profile && $candidate->profile->verification_status === 'verified')
                                    <img src="{{ asset('images/verified-badge.png') }}" alt="Verificado" class="h-4 w-4">
                                @endif
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $selectedCandidate->municipality}}, {{ $selectedCandidate->department }}
                            </p>
                            <div class="text-sm text-yellow-500 flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= round($candidate->employee->profile->average_rating) ? '' : '-o' }}"></i>
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
        <div class="w-full md:w-2/3 overflow-y-auto max-h-[70vh]">
            @isset($selectedCandidate)
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center gap-6 border-b pb-4 mb-4">
                        @php
                            $profile = auth()->user()->profile;
                        @endphp

                        <img src="{{ $profile && $profile->profile_picture
                                    ? asset('storage/' . $profile->profile_picture)
                                    : asset('images/default-user.jpg') }}"
                                     alt="Foto de perfil"
                                     class="w-20 h-20 rounded-full object-cover border" />
                        <div>
                        <p class="text-gray-700 font-semibold flex items-center gap-2">
                            {{ $candidate->employee->first_name }} {{ $candidate->employee->last_name }}
                            @if ($candidate->profile && $candidate->profile->verification_status === 'verified')
                                <img src="{{ asset('images/verified-badge.png') }}" alt="Verificado" class="h-4 w-4">
                            @endif
                        </p>
                            <div class="text-sm text-gray-600">{{ $selectedCandidate->municipality}}, {{ $selectedCandidate->department }}</div>
                            <div class="text-sm text-yellow-500 flex items-center">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star{{ $i < $selectedCandidate->user->average_rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl space-y-4">
                        <p><i class="fas fa-phone mr-2 text-amber-500"></i>{{ $selectedCandidate->user->phone ?? 'No especificado' }}</p>

                        <p class="space-y-2 my-2">
                            <i class="fas fa-calendar-alt mr-2 text-sky-500"></i>
                            {{ $selectedCandidate && $selectedCandidate->birth_date
                                ? \Carbon\Carbon::parse($selectedCandidate->birth_date)->format('d/m/Y')
                                : 'No especificado' }}
                        </p>
                        @php
                            $generos = [
                                'male' => 'Masculino',
                                'female' => 'Femenino',
                                'other' => 'Otro',
                            ];
                        @endphp
                        <p><i class="fas fa-venus-mars mr-2 text-purple-500"></i>{{ $generos[$selectedCandidate->gender] ?? 'No especificado' }}</p>
                        <p><i class="fas fa-map-marker-alt mr-2 text-rose-500"></i>{{ $selectedCandidate->municipality }}, {{ $selectedCandidate->department }} , zona {{ $selectedCandidate->zone }}, {{ $selectedCandidate->neighborhood }}.</p>
                        <div>
                            <h3 class="font-semibold text-gray-700">Experiencia</h3>
                            <p class="text-gray-600">{{ $selectedCandidate->experience ?? 'No disponible' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Descripción personal</h3>
                            <p class="text-gray-600">{{ $selectedCandidate->bio ?? 'No disponible' }}</p>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Categorías de interes</h3>
                        @if(!empty($selectedCandidate->work_categories))
                            @foreach($selectedCandidate->work_categories as $cat)
                                <span class="inline-block bg-purple-100 text-purple-800 text-xs px-3 py-2 rounded-full mr-2">{{ $cat }}</span>
                            @endforeach
                        @else
                            <p class="text-gray-500">No seleccionadas.</p>
                        @endif
                    </div>
                </div>
            @endisset
                <div class="relative bg-white rounded-2xl py-8 cursor-pointer transition">
                    <div class="absolute bottom-3 right-3 flex gap-2">
                        {{-- Botón de mensajería --}}
                        <a href="{{ route('chat.show', $candidate->employee->id) }}"
                           class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-2xl text-sm flex items-center gap-1 shadow">
                            <i class="fas fa-comment-dots"></i>
                        </a>

                        {{-- Botón de rechazar --}}
                        <form action="#" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-2xl text-sm shadow">
                                Rechazar
                            </button>
                        </form>
                        {{-- Botón de aceptar --}}
                        <form action="{{ route('applications.accept', $candidate->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-2xl text-sm shadow">
                                Aceptar
                            </button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection
