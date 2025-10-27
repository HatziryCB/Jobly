@extends('layouts.app')
@section('title', 'Editar oferta')

@section('content')
        <form method="POST" action="{{ route('offers.update', $offer) }}">
            @csrf
            @method('PUT')
            @include('offers.form', ['offer' => $offer, 'submitLabel' => 'Guardar cambios'])
        </form>
@endsection
