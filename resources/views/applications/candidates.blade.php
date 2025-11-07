@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="flex flex-col md:flex-row gap-4">
        {{-- Lista de candidatos a la izquierda --}}
        <div class="w-full md:w-1/3 space-y-4 overflow-y-auto max-h-[70vh] pr-2">
            @forelse ($applications as $application)
                @php
                    $candidate = $application->employee; // Usuario completo
                    $profile = $candidate->profile;
                @endphp

                <div class="bg-white rounded-2xl shadow p-4 hover:shadow-md transition cursor-pointer relative candidate-card"
                     data-url="{{ route('applications.candidate.show', [$offer->id, $candidate->id]) }}">
                @if ($application->status === 'accepted')
                        <div class="absolute bottom-2 right-2 bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full shadow">
                            Contratado
                        </div>
                    @elseif ($application->status === 'rejected')
                        <div class="absolute bottom-2 right-2 bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full shadow">
                            Rechazado
                        </div>
                    @endif

                    <div class="flex items-center gap-4">
                        <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('images/default-user.jpg') }}"
                             class="w-14 h-14 rounded-full object-cover border" />

                        <div>
                            <div class="flex items-center gap-2 font-semibold text-gray-800">
                                <x-verification-badge :status="$profile->verification_status" :firstName="$candidate->first_name" :lastName="$candidate->last_name" layout="inline"/>
                            </div>

                            <p class="text-sm text-gray-600">{{ $profile->municipality }}, {{ $profile->department }}</p>

                            <div class="text-yellow-500 text-sm">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= ($profile->average_rating ?? 0) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-gray-600">No hay candidatos aún.</p>
            @endforelse
        </div>

        {{-- Panel derecho --}}
        <div id="candidate-detail" class="w-full md:w-2/3 overflow-y-auto max-h-[70vh]">
            @isset($selectedCandidate)
                @include('applications.partials._candidate_detail')
            @endisset
        </div>

        {{-- Script para AJAX --}}
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const candidateCards = document.querySelectorAll('.candidate-card');

                    candidateCards.forEach(card => {
                        card.addEventListener('click', async () => {
                            const url = card.dataset.url;
                            const panel = document.getElementById('candidate-detail');

                            panel.innerHTML = '<div class="text-center p-6 text-gray-500">Cargando...</div>';

                            try {
                                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                                const html = await res.text();
                                panel.innerHTML = html;
                            } catch (err) {
                                panel.innerHTML = '<div class="text-center p-6 text-red-500">Error al cargar el candidato.</div>';
                            }
                        });
                    });
                });
            </script>
        @endpush
    </div>
@endsection
