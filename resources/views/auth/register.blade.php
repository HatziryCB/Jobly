@extends('layouts.base')

@section('title', 'Registrarme - Jobly')
@section('form-title', 'Crear cuenta')
@section('card-max-w','w-full max-w-4xl')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        {{-- Nombre --}}
        <div>
            <label for="first_name" class="block text-sm font-medium mb-1">Nombres</label>
            <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
            @error('first_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Apellido --}}
        <div>
            <label for="last_name" class="block text-sm font-medium mb-1">Apellidos</label>
            <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
            @error('last_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Correo --}}
        <div class="md:col-span-2">
            <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
            @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="phone" class="block text-sm font-medium mb-1">Teléfono</label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]"
                   placeholder="+502 5XXX XXXX">
            @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Tipo de cuenta --}}
        <div>
            <label for="account_type" class="block text-sm font-medium mb-1">Tipo de cuenta</label>
            <select id="account_type" name="account_type" required
                    class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                <option value="" disabled {{ old('account_type') ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="hire" {{ old('account_type') === 'hire' ? 'selected' : '' }}>Quiero contratar</option>
                <option value="work" {{ old('account_type') === 'work' ? 'selected' : '' }}>Quiero trabajar</option>
            </select>
            @error('account_type')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
            @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Confirmar --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
        </div>

        {{-- Términos --}}
        <div class="md:col-span-2 flex items-start gap-2">
            <input id="terms" name="terms" type="checkbox" value="accepted" required
                   class="mt-1 border-gray-300 text-[var(--brand-primary)] focus:ring-[var(--brand-secondary)]">
            <label for="terms" class="text-sm">
                Acepto los <a href="#" class="text-[var(--brand-primary)] underline">Términos</a> y <a href="#" class="text-[var(--brand-primary)] underline">Privacidad</a>.
            </label>
        </div>

        {{-- Botón --}}
        <div class="md:col-span-2">
            <button type="submit"
                    class="w-full rounded-xl bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] text-white font-semibold py-2.5 transition">
                Registrarme
            </button>
            <p class="text-center text-sm mt-3">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-[var(--brand-primary)] font-medium hover:underline">Inicia sesión</a>
            </p>
        </div>
    </form>
@endsection
