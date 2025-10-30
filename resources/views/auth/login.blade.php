@extends('layouts.guest')
@section('form-title','Iniciar sesión')
@section('form-subtitle','Ingresa tus credenciales para continuar')
@section('card-max-w','w-full max-w-3xl')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden flex w-full max-w-4xl">
            <!-- Imagen lateral -->
            <div class="hidden md:block col-span-1 relative">
                <img src="https://images.unsplash.com/photo-1657185140919-db37897e0fd5?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                     alt="Trabajo temporal"
                     class="w-full h-full object-cover" />
            </div>

            <!-- Formulario -->
            <div class="w-full md:w-2/3 p-8">
                <h2 class="text-2xl font-bold mb-6 text-center">Inicio de sesión</h2>

                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)]">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>

                        <div class="relative">
                            <input
                                :type="show ? 'text' : 'password'"
                                id="password"
                                name="password"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)] pr-10"
                            >

                            <!-- Botón del ojo -->
                            <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                <!-- Ojo cerrado -->
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Ojo abierto -->
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.147 5.17M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

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
            </div>
        </div>
    </div>
@endsection
