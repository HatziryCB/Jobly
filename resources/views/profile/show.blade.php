@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Columna izquierda - resumen --}}
        <div class="lg:w-1/3 bg-white p-6 rounded-xl shadow space-y-6">
            <div class="text-center">
                <img src="{{ $user->profile->profile_picture ? asset('storage/' . $user->profile->profile_picture) : asset('images/default-user.jpg') }}"
                     class="w-20 h-20 rounded-full mx-auto mt-5 mb-10 object-cover">

                <h2 class="text-xl font-bold mt-2">
                    {{ $user->first_name }} {{ $user->last_name }}
                    @if($user->profile->verification_status === 'verified')
                        <span title="Usuario verificado">
                        <img src="/images/verified-badge.png" alt="Verificado" class="inline w-5 h-5 ml-1">
                    </span>
                    @endif
                </h2>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            </div>

            <div class="space-y-2 mb-5">
                <p><i class="fas fa-phone mr-2 text-amber-500"></i>{{ $user->phone ?? 'No especificado' }}</p>
                <p><i class="fas fa-calendar-alt mr-2 text-sky-500"></i>{{ $user->profile->birth_date ? \Carbon\Carbon::parse($user->profile->birth_date)->format('d/m/Y') : 'No especificado' }}</p>
                @php
                    $generos = [
                        'male' => 'Masculino',
                        'female' => 'Femenino',
                        'other' => 'Otro',
                    ];
                @endphp
                <p><i class="fas fa-venus-mars mr-2 text-purple-500"></i>{{ $generos[$user->profile->gender] ?? 'No especificado' }}</p>
                <p><i class="fas fa-map-marker-alt mr-2 text-rose-500"></i>{{ $user->profile->municipality }}, {{ $user->profile->department }} , zona {{ $user->profile->zone }}, {{ $user->profile->neighborhood }}.</p>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('profile.edit', $user->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 text-sm">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>

                <a href="#" class="px-2 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 text-sm">
                    <i class="fas fa-check-circle mr-1"></i> Solicitar verificación
                </a>
            </div>
        </div>

        {{-- Columna derecha - info detallada --}}
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
