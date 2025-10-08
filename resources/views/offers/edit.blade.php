<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Editar oferta</h2></x-slot>
    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('offers.update', $offer) }}">
            @csrf
            @method('PUT')
            @include('offers._form', ['offer' => $offer, 'submitLabel' => 'Actualizar'])
        </form>
    </div>
</x-app-layout>
