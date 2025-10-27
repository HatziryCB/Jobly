@extends('layouts.app')
@section('title', 'Publicar nueva oferta')

@section('content')
        <form method="POST" action="{{ route('offers.store') }}" >
            @csrf
            @include('offers.form', ['submitLabel' => 'Publicar'])
        </form>

@endsection

