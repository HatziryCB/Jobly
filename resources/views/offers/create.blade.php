<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Publicar oferta</h2></x-slot>
    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('offers.store') }}">
            @csrf
            @include('offers._form', ['offer' => null, 'submitLabel' => 'Publicar'])
        </form>
    </div>
</x-app-layout>
