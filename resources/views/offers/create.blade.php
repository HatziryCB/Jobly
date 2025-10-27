@extends('layouts.app')
@section('title', 'Publicar nueva oferta')

@section('content')
    <div class="max-w-3xl mx-auto" >
        <h1 class="text-2xl font-bold mb-8">Publicar nueva oferta</h1>

        <form method="POST" action="{{ route('offers.store') }}" >
            @csrf
            @include('offers.form', ['submitLabel' => 'Publicar'])
        </form>
    </div>
@endsection

