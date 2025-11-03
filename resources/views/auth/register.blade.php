@extends('layouts.guest')
@section('title', 'Registrarme - Jobly')
@section('form-title', 'Crear cuenta')
@section('form-subtitle', 'Únete a Jobly y encuentra oportunidades cerca de ti')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 px-4 py-10">
        <div class="w-full max-w-5xl bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col md:flex-row">

            <!-- Imagen lateral -->
            <div class="hidden md:block md:w-1/2">
                <img src="https://images.unsplash.com/photo-1657185140919-db37897e0fd5?q=80&w=687&auto=format&fit=crop"
                     alt="Registro Jobly"
                     class="w-full h-full object-cover">
            </div>

            <!-- Formulario -->
            <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-center text-[var(--text)] mb-2">Crea tu cuenta</h2>
                <p class="text-center text-gray-600 mb-6 text-sm">@yield('form-subtitle')</p>

                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <!-- Nombres -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium mb-1">Primer nombre <span class="text-red-600">*</span></label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    </div>

                    <div>
                        <label for="second_name" class="block text-sm font-medium mb-1">Segundo nombre</label>
                        <input id="second_name" name="second_name" type="text" value="{{ old('second_name') }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium mb-1">Primer apellido <span class="text-red-600">*</span></label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    </div>

                    <div>
                        <label for="second_last_name" class="block text-sm font-medium mb-1">Segundo apellido</label>
                        <input id="second_last_name" name="second_last_name" type="text" value="{{ old('second_last_name') }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium mb-1">Correo electrónico <span class="text-red-600">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1">Teléfono</label>
                        <input id="phone" name="phone" type="tel" maxlength="8" pattern="[0-9]{8}" value="{{ old('phone') }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]" placeholder="XXXX XXXX">
                    </div>

                    <!-- Tipo de cuenta -->
                    <div>
                        <label for="role" class="block text-sm font-medium mb-1">Tipo de cuenta <span class="text-red-600">*</span></label>
                        <select id="role" name="role" required class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)]">
                            <option value="" disabled selected>Selecciona...</option>
                            <option value="employer">Quiero contratar</option>
                            <option value="employee">Quiero trabajar</option>
                        </select>
                    </div>

                    <!-- Contraseña y Confirmación -->
                    <div x-data="{ showPass: false, showConfirm: false }" class="md:col-span-2 grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                                       class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)] pr-10">
                                <button type="button" @click="showPass = !showPass"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                    <i x-show="!showPass" class="fa-solid fa-eye"></i>
                                    <i x-show="showPass" class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                            <div class="relative">
                                <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                       class="w-full rounded-xl border-gray-300 focus:ring-[var(--brand-secondary)] pr-10">
                                <button type="button" @click="showConfirm = !showConfirm"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 focus:outline-none">
                                    <i x-show="!showConfirm" class="fa-solid fa-eye"></i>
                                    <i x-show="showConfirm" class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Términos -->
                    <div class="md:col-span-2 flex items-start gap-2">
                        <input id="terms" name="terms" type="checkbox" required
                               class="mt-1 border-gray-300 text-[var(--brand-primary)] focus:ring-[var(--brand-secondary)]">
                        <label for="terms" class="text-sm text-gray-700">
                            Acepto los <a href="#" class="text-[var(--brand-primary)] underline">Términos</a> y <a href="#" class="text-[var(--brand-primary)] underline">Política de Privacidad</a>.
                        </label>
                    </div>

                    <!-- Botón -->
                    <div class="md:col-span-2 mt-4">
                        <button type="submit"
                                class="w-full bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] text-white font-semibold py-2.5 rounded-xl transition">
                            Registrarme
                        </button>
                        <p class="text-center text-sm mt-3 text-gray-600">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}" class="text-[var(--brand-primary)] font-medium hover:underline">Inicia sesión</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
