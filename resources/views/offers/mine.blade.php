<?php
@extends('layouts.app')

@section('title', 'Mis publicaciones')

@section('content')
    <section class="container mx-auto">
        <h1 class="text-2xl font-bold text-indigo-600 mb-6">Mis ofertas publicadas</h1>

        @if($offers->isEmpty())
            <p class="text-gray-600">Aún no has publicado ninguna oferta.</p>
        @else
            <div class="space-y-4">
                @foreach($offers as $offer)
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $offer->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $offer->description }}</p>
                        <p class="text-sm mt-1 text-gray-500">{{ $offer->location_text }} • {{ $offer->category }}</p>
                        <p class="text-sm mt-1 font-medium text-green-700">Q{{ $offer->pay_min }} - Q{{ $offer->pay_max }}</p>
                        <p class="text-sm mt-1 text-gray-400">Estado: {{ ucfirst($offer->status) }}</p>

                        <div class="flex gap-4 mt-3">
                            <a href="{{ route('offers.edit', $offer) }}" class="text-indigo-600 hover:underline">Editar</a>
                            <form action="{{ route('offers.destroy', $offer) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
