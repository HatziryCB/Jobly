@extends('layouts.dashboard')

@section('title', 'Candidatos para: ' . $offer->title)

@section('dashboard-content')
    <h2 class="text-2xl font-semibold mb-4 text-purple-700">Candidatos postulados</h2>

    @forelse($applications as $application)
        <div class="bg-white rounded-xl p-4 shadow mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $application->employee->first_name }} {{ $application->employee->last_name }}
                    </h3>
                    <p class="text-gray-600 text-sm">Mensaje: {{ $application->message ?? 'Sin mensaje.' }}</p>
                </div>
                <div>
                    <form action="{{ route('applications.accept', $application) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Aceptar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Aún no hay postulaciones para esta oferta.</p>
    @endforelse
@endsection
