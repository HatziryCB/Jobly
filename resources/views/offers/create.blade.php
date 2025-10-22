@extends('layouts.app')
@section('title', 'Publicar nueva oferta')

@section('content')
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-6">Publicar nueva oferta</h1>

        <form method="POST" action="{{ route('offers.store') }}">
            @csrf
            @include('offers.form', ['submitLabel' => 'Publicar'])
        </form>
    </div>
@endsection

