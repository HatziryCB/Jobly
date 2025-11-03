@extends('layouts.guest')
@section('title', 'Verifica tu correo')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md text-center">
            <h1 class="text-2xl font-bold text-[var(--brand-primary)] mb-4">¡Confirma tu correo!</h1>
            <p class="text-gray-600 mb-6">
                Te enviamos un enlace de verificación a <strong>{{ auth()->user()->email }}</strong>.
                <br>Por favor revisa tu bandeja de entrada o spam.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] text-white font-semibold py-2.5 rounded-xl transition">
                    Reenviar correo
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-[var(--brand-primary)]">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
@endsection
