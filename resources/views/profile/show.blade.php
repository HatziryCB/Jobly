@extends('layouts.app')

@section('title', 'Perfil de usuario')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow rounded-xl p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $user->first_name }} {{ $user->last_name }}</h1>
        <p class="text-gray-600">Email: {{ $user->email }}</p>
    </div>
@endsection

