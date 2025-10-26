<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">{{ $offer->title }}</h2></x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

            {{-- Detalles generales --}}
            <div class="bg-white p-6 rounded shadow space-y-2">
                <p class="text-gray-600 text-sm">Ubicación: {{ $offer->location_text ?? 'Sin ubicación' }}</p>
                <p class="text-gray-600 text-sm">Categoría: {{ $offer->category }}</p>
                <p class="text-gray-600 text-sm">Pago: Q{{ $offer->pay_min ?? '?' }} - Q{{ $offer->pay_max ?? '?' }}</p>

                @if($offer->requirements)
                    <p class="text-gray-600 text-sm">Requisitos: {{ $offer->requirements }}</p>
                @endif

                @if($offer->estimated_duration_unit)
                    <p class="text-gray-600 text-sm">
                        Duración estimada:
                        @if($offer->estimated_duration_unit === 'hasta finalizar')
                            Hasta finalizar el trabajo
                        @else
                            {{ $offer->estimated_duration_quantity }} {{ $offer->estimated_duration_unit }}
                        @endif
                    </p>
                @endif

                <p class="mt-2">{{ $offer->description }}</p>
            </div>


            {{-- Empleador --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Publicado por:</h3>
            <p class="text-gray-800 font-medium">{{ $offer->employer->name }}</p>
            {{-- Aquí puedes agregar estrellas de calificación en el futuro --}}
            <p class="text-gray-600 text-sm">Contrataciones anteriores:
                {{ $offer->employer->offers()->where('status', 'hired')->count() }}
            </p>
        </div>

        @auth
            {{-- Empleado: Formulario para postular --}}
            @if(auth()->user()->hasRole('employee'))
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-semibold mb-2">¿Interesado en esta oferta?</h3>
                    <form method="POST" action="{{ route('offers.apply', $offer) }}" class="space-y-2">
                        @csrf
                        <textarea name="message" rows="3" class="w-full border rounded p-2" placeholder="Mensaje (opcional)">{{ old('message') }}</textarea>
                        <x-primary-button>Postularme</x-primary-button>
                    </form>
                </div>
            @endif

            {{-- Empleador: Ver postulaciones --}}
            @if(auth()->id() === $offer->employer_id)
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-lg font-semibold mb-4">Postulaciones</h3>
                    @forelse($offer->applications()->latest()->get() as $app)
                        <div class="border rounded p-4 mb-3">
                            <p class="font-medium text-gray-800">{{ $app->employee->name }}</p>
                            <p class="text-sm text-gray-600">Mensaje: {{ $app->message ?? 'Sin mensaje' }}</p>
                            <p class="text-sm text-gray-500">Estado: {{ ucfirst($app->status) }}</p>
                            @if($app->status === 'pending')
                                <form method="POST" action="{{ route('applications.accept', $app) }}" class="mt-2">
                                    @csrf
                                    <x-primary-button>Aceptar</x-primary-button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-600">No hay postulaciones aún.</p>
                    @endforelse
                </div>
            @endif
        @endauth
    </div>
</x-app-layout>
