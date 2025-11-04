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

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4" x-data="{ show1:false, show2:false }">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="relative">
                    <label for="password" class="block text-sm font-medium mb-1">Nueva contraseña</label>
                    <input :type="show1 ? 'text' : 'password'" id="password" name="password" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)] pr-10">
                    <button type="button" @click="show1 = !show1"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                        <svg x-show="!show1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.147 5.17M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18" />
                        </svg>
                    </button>
                    @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                    <input :type="show2 ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                           class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)] pr-10">
                    <button type="button" @click="show2 = !show2"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                        <svg x-show="!show2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.147 5.17M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                {{-- Botón --}}
                <button type="submit"
                        class="w-full bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] text-white font-semibold py-2.5 rounded-xl transition">
                    Guardar nueva contraseña
                </button>
            </form>
        </div>
    </div>
@endsection
