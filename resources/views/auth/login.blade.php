@extends('layouts.base')

@section('form-title','Iniciar sesión')
@section('form-subtitle','Ingresa tus credenciales para continuar')
@section('card-max-w','w-full max-w-3xl')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)]">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)]">
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"
                       class="rounded border-slate-300 text-[var(--brand-primary)] focus:ring-[var(--brand-secondary)]">
                Recuérdame
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[var(--brand-primary)] hover:underline"
                   href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full inline-flex justify-center items-center rounded-xl px-4 py-2.5 font-semibold text-white
                   bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] transition">
            Entrar
        </button>

        <p class="text-center text-sm">
            ¿No tienes cuenta en Jobly?
            <a href="{{ route('register') }}" class="font-medium text-[var(--brand-primary)] hover:underline">
                Crear una ahora
            </a>
        </p>
    </form>
@endsection
