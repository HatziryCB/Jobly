@extends('layouts.guest') {{-- Esto carga el navbar con el logo y demás --}}
@section('title', 'Registrarme - Jobly')
@section('form-title', 'Crear cuenta')
@section('card-max-w','w-full max-w-4xl')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-3">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden flex w-full max-w-5xl">
            <!-- Imagen lateral -->
            <div class="hidden md:block col-span-1 relative">
                <img src="https://images.unsplash.com/photo-1657185140919-db37897e0fd5?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                     alt="Trabajo temporal"
                     class="w-full h-full object-cover" />
            </div>

            <!-- Formulario -->
            <div class="w-full md:w-2/3 p-8">
                <h2 class="text-2xl font-bold mb-6 text-center">Registro</h2>

                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    {{-- Nombre --}}
                    <div>
                        <label for="first_name" class="block text-sm font-medium mb-1">Nombres <span class="text-red-600">*</span></label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                        @error('first_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Apellido --}}
                    <div>
                        <label for="last_name" class="block text-sm font-medium mb-1">Apellidos <span class="text-red-600">*</span></label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                        @error('last_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Correo --}}
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium mb-1">Correo electrónico <span class="text-red-600">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                        @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1">Teléfono</label>
                        <input id="phone" name="phone" type="tel" maxlength="8" minlength="8" pattern="[0-9]{8}" value="{{ old('phone') }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]"
                               placeholder="XXXX XXXX">
                        @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Tipo de cuenta --}}
                    <div>
                        <label for="role" class="block text-sm font-medium mb-1">
                            Tipo de cuenta <span class="text-red-600">*</span>
                        </label>
                        <select id="role" name="role" required
                                class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona...</option>
                            <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>Quiero contratar</option>
                            <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Quiero trabajar</option>
                        </select>
                        @error('role')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

                    </div>

                    <div x-data="{ showPassword: false, showConfirm: false, password: '', confirm: '' }" class="md:col-span-2 grid md:grid-cols-2 gap-4">

                        {{-- Contraseña --}}
                        <div>
                            <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
                            <div class="relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    x-model="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)] pr-10"
                                >
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
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

                        {{-- Confirmar contraseña --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                            <div class="relative">
                                <input
                                    :type="showConfirm ? 'text' : 'password'"
                                    x-model="confirm"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border-slate-300 focus:border-[var(--brand-secondary)] focus:ring-[var(--brand-secondary)] pr-10"
                                >
                                <button type="button" @click="showConfirm = !showConfirm"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                    <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.147 5.17M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Alerta visual si no coinciden --}}
                        <div class="col-span-2">
                            <template x-if="password && confirm && password !== confirm">
                                <p class="text-sm text-red-600 mt-2">⚠️ Las contraseñas no coinciden.</p>
                            </template>
                        </div>

                    </div>

                    {{-- Términos --}}
                    <div class="md:col-span-2 flex items-start gap-2">
                        <input id="terms" name="terms" type="checkbox" value="accepted" required
                               class="mt-1 border-gray-300 text-[var(--brand-primary)] focus:ring-[var(--brand-secondary)]">
                        <label for="terms" class="text-sm">
                            Acepto los <a href="#" class="text-[var(--brand-primary)] underline">Términos </a> y <a href="#" class="text-[var(--brand-primary)] underline">Privacidad</a>.
                            <span class="text-red-600">*</span>
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
            </div>
        </div>
    </div>
@endsection
