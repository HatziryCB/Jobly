@php
    $profile = $selectedCandidate->profile;
@endphp

<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex items-center gap-6 border-b pb-4 mb-4">

        <img src="{{ $profile->profile_picture ? asset('storage/'.$profile->profile_picture) : asset('images/default-user.jpg') }}"
             class="w-20 h-20 rounded-full object-cover border">

        <div>
            <x-verification-badge
                :status="$profile->verification_status"
                :firstName="$selectedCandidate->first_name"
                :lastName="$selectedCandidate->last_name"
                layout="inline"
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

    <div class="space-y-3">
        <p><i class="fas fa-phone text-amber-500 mr-2"></i>{{ $selectedCandidate->phone ?? 'No especificado' }}</p>
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
    @php
        $applicationId = $application->id;
    @endphp
    @php
        $application = $offer->applications()->where('employee_id', $selectedCandidate->id)->first();
    @endphp

    @if ($application && $application->status === 'accepted')
        <div class="text-green-600 font-semibold mb-2">Este candidato fue contratado.</div>
        <a href="{{ route('chat.show', $selectedCandidate->id) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-2xl text-sm flex items-center gap-1 shadow">
            <i class="fas fa-comment-dots"></i> Mensajear
        </a>
    @elseif ($application && $application->status === 'rejected')
        <div class="text-red-600 font-semibold mb-2">Candidato rechazado.</div>
    @else
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('chat.show', $selectedCandidate->id) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-2xl text-sm flex items-center gap-1 shadow">
                <i class="fas fa-comment-dots"></i> Mensajear
            </a>

            <form action="{{ route('applications.reject', [$offer->id, $selectedCandidate->id]) }}" method="POST">
                @csrf
                <button class="bg-gray-200 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-2xl text-sm flex items-center gap-1 shadow">
                    <i class="fas fa-times-circle"></i> Rechazar
                </button>
            </form>

            <form action="{{ route('applications.accept', [$offer->id, $selectedCandidate->id]) }}" method="POST">
                @csrf
                <button class="bg-green-300 hover:bg-blue-200 text-green-800 px-3 py-1 rounded-2xl text-sm flex items-center gap-1 shadow">
                    <i class="fas fa-check-circle"></i> Aceptar
                </button>
            </form>
        </div>
    @endif
</div>

