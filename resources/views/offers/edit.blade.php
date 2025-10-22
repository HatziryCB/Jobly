@extends('layouts.app')
@section('title', 'Editar oferta')

@section('content')
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-6">Editar oferta</h1>

        <form method="POST" action="{{ route('offers.update', $offer) }}">
            @csrf
            @method('PUT')
            @include('offers.form', ['offer' => $offer, 'submitLabel' => 'Guardar cambios'])
        </form>
    </div>
@endsection
