@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
        <div class="flex items-center gap-6 border-b pb-4 mb-4">
            <img src="{{ $profile->profile_picture ? asset('storage/'.$profile->profile_picture) : asset('images/default-user.jpg') }}"
                 class="w-20 h-20 rounded-full object-cover border">

            <div>
                <x-verification-badge
                    :status="$profile->user->verification_status"
                    :firstName="$profile->user->first_name"
                    :lastName="$profile->user->last_name"
                    layout="stacked"
                />

                <p class="text-sm text-gray-600 mt-1">
                    {{ $profile->municipality }}, {{ $profile->department }}
                </p>

                <div class="text-yellow-500 text-sm mb-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= ($profile->average_rating ?? 0) ? '' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
            </div>
        </div>

        <div class="space-y-3 text-sm">
            <p><i class="fas fa-phone text-amber-500 mr-2"></i>{{ $employer->phone ?? 'No especificado' }}</p>
            <p><i class="fas fa-calendar text-sky-500 mr-2"></i>{{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('d/m/Y') : 'No especificado' }}</p>
            <p><i class="fas fa-venus-mars text-purple-500 mr-2"></i>{{ ['male'=>'Masculino','female'=>'Femenino','other'=>'Otro'][$profile->gender] ?? 'No especificado' }}</p>
            <p><i class="fas fa-map-marker-alt text-rose-500 mr-2"></i>{{ $profile->municipality }}, {{ $profile->department }}</p>

            <h3 class="font-semibold">Experiencia</h3>
            <p class="text-gray-700">{{ $profile->experience ?? 'No disponible' }}</p>

            <h3 class="font-semibold">Descripción personal</h3>
            <p class="text-gray-700">{{ $profile->bio ?? 'No disponible' }}</p>

            <h3 class="font-semibold">Categorías de interés</h3>
            @forelse($profile->work_categories ?? [] as $cat)
                <span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full">{{ $cat }}</span>
            @empty
                <p class="text-gray-500 text-sm">No seleccionadas.</p>
            @endforelse
        </div>

        <div class="mt-6 text-right">
            <a href="{{ url()->previous() }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i>Regresar
            </a>
        </div>
    </div>
@endsection
