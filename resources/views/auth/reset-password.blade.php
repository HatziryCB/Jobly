@extends('layouts.guest')
@section('title', 'Restablecer contraseña')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-10">
        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
            <h1 class="text-2xl font-bold text-center text-[var(--brand-primary)] mb-4">
                Restablecer contraseña
            </h1>

            <p class="text-gray-600 text-sm text-center mb-6">
                Ingresa tu nueva contraseña para continuar.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Nueva contraseña</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                </div>

                <button type="submit"
                        class="w-full bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] text-white font-semibold py-2.5 rounded-xl transition">
                    Guardar nueva contraseña
                </button>
            </form>
        </div>
    </div>
@endsection
