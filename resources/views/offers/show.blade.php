<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">{{ $offer->title }}</h2></x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        @if (session('status'))
            <div class="mb-3 alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="mb-2 text-muted small">
            {{ $offer->location_text ?? 'Sin ubicación' }} ·
            Q{{ $offer->pay_min ?? '?' }} - Q{{ $offer->pay_max ?? '?' }}
        </div>
        <p class="mb-4">{{ $offer->description }}</p>

            @auth
                {{-- Si soy empleado: botón para postular --}}
                @if (auth()->user()->role === 'employee')
                    <form method="POST" action="{{ route('offers.apply',$offer) }}" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="message" class="form-control" placeholder="Mensaje (opcional)">
                        <button class="btn btn-primary btn-sm">Postular</button>
                    </form>
                @endif

                {{-- Si soy el empleador: listar postulaciones y aceptar --}}
                @if (auth()->id() === $offer->employer_id)
                    <h6 class="mt-4">Postulaciones</h6>
                    @php($applications = \App\Models\Application::where('offer_id',$offer->id)->latest()->get())
                    @forelse($applications as $app)
                        <div class="border rounded p-2 mb-2">
                            <div class="small text-muted">Empleado #{{ $app->employee_id }} · Estado: {{ $app->status }}</div>
                            @if($app->message)<div>{{ $app->message }}</div>@endif
                            @if($app->status==='pending')
                                <form method="POST" action="{{ route('applications.accept',$app) }}" class="mt-2">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Aceptar</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">No hay postulaciones todavía.</p>
                    @endforelse
                @endif
            @endauth

    </div>
</x-app-layout>
