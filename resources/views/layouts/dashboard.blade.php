@extends('layouts.app')

@section('content')
    <div class="flex gap-4">
        {{-- Sidebar --}}
        @include('components.dashboard.sidebar')

        {{-- Contenido principal con header y contenido dinámico --}}
        <div class="flex-1 space-y-4">
            @include('components.dashboard.header')
            <div class="bg-white p-6 rounded-xl shadow">
                @yield('dashboard-content')
            </div>
        </div>
    </div>
@endsection
