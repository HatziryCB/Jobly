<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Ofertas</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        {{-- Flash message --}}
        @if (session('status'))
            <div class="mb-4 alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="GET" class="mb-4 d-flex gap-2">
            <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por título o descripción">
            <button class="btn btn-primary">Buscar</button>
            @auth
                @if (auth()->user()->role==='employer')
                    <a href="{{ route('offers.create') }}" class="btn btn-success">Publicar oferta</a>
                @endif
            @endauth
        </form>

        @forelse($offers as $offer)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $offer->title }}</h5>
                    <div class="text-muted small mb-2">
                        {{ $offer->location_text ?? 'Sin ubicación' }} ·
                        Q{{ $offer->pay_min ?? '?' }} - Q{{ $offer->pay_max ?? '?' }}
                    </div>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($offer->description, 180) }}</p>
                    <a href="{{ route('offers.show',$offer) }}" class="btn btn-outline-primary btn-sm">Ver detalle</a>
                </div>
            </div>
        @empty
            <p class="text-muted">No hay ofertas disponibles.</p>
        @endforelse

        {{ $offers->links() }}
    </div>
</x-app-layout>
