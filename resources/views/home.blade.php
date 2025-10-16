<x-guest-layout>

    {{-- HERO --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
                        Encuentra ayuda confiable para tus tareas
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Profesionales cercanos para trabajos temporales: limpieza, pintura, mudanza, jardinería, reparaciones y más.
                    </p>

                    {{-- Buscador --}}
                    <form action="{{ route('offers.index') }}" method="GET" class="mt-8">
                        <div class="w-full max-w-2xl shadow-lg rounded-full overflow-hidden flex">
                            <input name="q"
                                   class="flex-1 min-w-0 px-5 py-4 text-gray-900 focus:outline-none"
                                   placeholder="¿Qué necesitas hoy? (p. ej., Pintor, Limpieza, Jardinería)">
                            <button class="px-6 py-4 font-semibold text-white"
                                    style="background:#6C5CE7">Buscar</button>
                        </div>
                    </form>

                    {{-- Chips categorías --}}
                    <div class="mt-6 flex flex-wrap gap-3">
                        @foreach (['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Cuidado de niños','Electricidad','Plomería'] as $cat)
                            <a href="{{ route('offers.index',['q'=>$cat]) }}"
                               class="px-4 py-2 rounded-full border text-gray-700 hover:bg-gray-50">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="absolute -inset-6 rounded-3xl"
                             style="background:linear-gradient(135deg,#6C5CE7 0%,#7C4DFF 40%,#00B4D8 100%); opacity:.18; filter:blur(24px);"></div>
                        <img class="relative rounded-3xl shadow-2xl"
                             src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YnVzcXVlZGElMjBkZSUyMGVtcGxlb3xlbnwwfHwwfHx8MA%3D%3D"
                             alt="Trabajos temporales">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ¿POR QUÉ JOBLY?  Beneficios vs métodos informales --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">¿Por qué Jobly y no redes o referidos?</h2>
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-2xl shadow flex gap-4">
                    <div class="shrink-0">
                        {{-- Escudo --}}
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="#6C5CE7"><path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Perfiles verificados</h3>
                        <p class="text-gray-600 mt-1">Identidad revisada y reputación bidireccional. Reduce suplantaciones y estafas comunes en redes.</p>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow flex gap-4">
                    <div class="shrink-0">
                        {{-- Reloj --}}
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="#7C4DFF"><path d="M12 1a11 11 0 100 22 11 11 0 000-22zm1 6h-2v6l5 3 1-1-4-2V7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Más rápido</h3>
                        <p class="text-gray-600 mt-1">Emparejamiento por ubicación y categoría. Menos ida y vuelta que en grupos de Facebook o WhatsApp.</p>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow flex gap-4">
                    <div class="shrink-0">
                        {{-- Candado --}}
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="#00B4D8"><path d="M12 2a5 5 0 00-5 5v3H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-2V7a5 5 0 00-5-5zm-3 8V7a3 3 0 116 0v3H9z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Privacidad y control</h3>
                        <p class="text-gray-600 mt-1">Datos resguardados y comunicación en la plataforma. No expone teléfonos en público.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CÓMO FUNCIONA (con iconos) --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">¿Cómo funciona?</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-2xl shadow">
                    <div class="mb-3">
                        {{-- lupa --}}
                        <svg class="h-12 w-12" viewBox="0 0 24 24" fill="#6C5CE7"><path d="M21 20l-4.35-4.35A7.5 7.5 0 1017.5 18L22 22l-1-2zM4 10a6 6 0 1112 0A6 6 0 014 10z"/></svg>
                    </div>
                    <div class="text-xl font-bold">1. Busca o publica</div>
                    <p class="text-gray-600 mt-2">Crea una oferta o encuentra tareas cercanas usando filtros y mapa.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow">
                    <div class="mb-3">
                        {{-- chat --}}
                        <svg class="h-12 w-12" viewBox="0 0 24 24" fill="#7C4DFF"><path d="M2 3h20v12H6l-4 4V3z"/></svg>
                    </div>
                    <div class="text-xl font-bold">2. Conecta y acuerda</div>
                    <p class="text-gray-600 mt-2">Chatea, resuelve dudas y coordina condiciones de forma segura.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow">
                    <div class="mb-3">
                        {{-- estrella --}}
                        <svg class="h-12 w-12" viewBox="0 0 24 24" fill="#00B4D8"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <div class="text-xl font-bold">3. Trabaja y califica</div>
                    <p class="text-gray-600 mt-2">Completa el trabajo, recibe pago fuera de la app y deja tu valoración.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PROYECTOS POPULARES (8 cards) --}}
    @php
        // Para cambiar imágenes: copia una URL de Unsplash y agrega query ?q=80&w=1200&auto=format&fit=crop
        $cards = [
          ['img'=>'https://plus.unsplash.com/premium_photo-1744995489261-eb3876aa6c81?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8YXJtYWRvJTIwZGUlMjBtdWVibGVzfGVufDB8fDB8fHww','t'=>'Armado de muebles'],
          ['img'=>'https://plus.unsplash.com/premium_photo-1663076480279-fb58ff002a26?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cmVwYXJhY2lvbmVzfGVufDB8fDB8fHww','t'=>'Pintura de interiores'],
          ['img'=>'https://plus.unsplash.com/premium_photo-1677683508374-a6f50382eb66?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGxpbXBpZXphfGVufDB8fDB8fHww','t'=>'Limpieza de hogar'],
          ['img'=>'https://images.unsplash.com/photo-1562259929-b4e1fd3aef09?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cmVwYXJhY2lvbmVzfGVufDB8fDB8fHww','t'=>'Reparaciones menores'],
          ['img'=>'https://images.unsplash.com/photo-1621460248083-6271cc4437a8?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8amFyZGluZXJpYXxlbnwwfHwwfHx8MA%3D%3D','t'=>'Jardinería'],
          ['img'=>'https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fG11ZGFuemF8ZW58MHx8MHx8fDA%3D','t'=>'Mudanza'],
          ['img'=>'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cmVwYXJhY2lvbmVzJTIwZWxlY3RyaWNhc3xlbnwwfHwwfHx8MA%3D%3D','t'=>'Electricidad básica'],
          ['img'=>'https://plus.unsplash.com/premium_photo-1663045495725-89f23b57cfc5?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cGxvbWVyaWF8ZW58MHx8MHx8fDA%3D','t'=>'Plomería']
        ];
    @endphp
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Proyectos populares</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($cards as $c)
                    <a href="{{ route('offers.index',['q'=>$c['t']]) }}" class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
                        <img class="h-44 w-full object-cover" src="{{ $c['img'] }}?q=80&w=1200&auto=format&fit=crop" alt="">
                        <div class="p-4">
                            <div class="font-semibold text-gray-900">{{ $c['t'] }}</div>
                            <div class="text-gray-600 text-sm mt-1">Ver disponibilidad cerca de ti</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIOS (con estrella demo) --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Personas que confían en Jobly</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ([['Ana','“Muy rápida la contratación.”',5],['Luis','“Encontré trabajo en un día.”',4],['María','“Me sentí segura con perfiles verificados.”',5]] as $t)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="font-bold text-gray-900 mb-1">{{ $t[0] }}</div>
                        <div class="flex gap-1 mb-2">
                            @for ($i=0; $i<5; $i++)
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="{{ $i < $t[2] ? '#F59E0B' : '#E5E7EB' }}"><path d="M10 15l-5.878 3.09L5.7 11.545.822 7.41l6.364-.925L10 1l2.814 5.485 6.364.925-4.878 4.135 1.578 6.545z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600">{{ $t[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA FINAL más vistoso --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="rounded-3xl p-10 text-center text-white"
                 style="background:linear-gradient(135deg,#6C5CE7 0%,#7C4DFF 40%,#00B4D8 100%);">
                <h2 class="text-4xl font-extrabold">Construye tu reputación o encuentra ayuda hoy</h2>
                <p class="mt-2 text-lg opacity-90">Publica una oferta o crea tu perfil en minutos.</p>
                <div class="mt-6 flex gap-3 justify-center">
                    <a href="{{ route('offers.create') }}" class="px-6 py-3 rounded-full bg-white text-[#6C5CE7] font-semibold">Publicar oferta</a>
                    <a href="{{ route('register') }}#register" class="px-6 py-3 rounded-full border-2 border-white text-white font-semibold">Crear cuenta</a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER tipo Thumbtack --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
            <div>
                <div class="font-extrabold text-gray-900">Jobly<br><span class="font-normal text-gray-600">Conéctalo. Listo.</span></div>
                <div class="flex gap-3 mt-4 text-gray-500">
                    <a href="https://wa.me/50200000000" aria-label="WhatsApp" class="hover:text-gray-700">
                        <svg class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor"><path d="M19.11 17.27c-.27-.14-1.6-.8-1.85-.9-.25-.09-.43-.14-.62.14-.18.27-.71.9-.87 1.09-.16.18-.32.2-.59.07-.27-.14-1.14-.42-2.17-1.34-.8-.71-1.35-1.58-1.51-1.85-.16-.27-.02-.42.12-.56.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.62-1.49-.85-2.05-.22-.53-.44-.46-.62-.47h-.53c-.18 0-.48.07-.73.34-.25.27-.96.94-.96 2.29s.99 2.65 1.13 2.83c.14.18 1.95 2.98 4.73 4.18.66.29 1.17.46 1.57.58.66.21 1.26.18 1.74.11.53-.08 1.6-.65 1.83-1.28.23-.63.23-1.18.16-1.29-.07-.11-.25-.18-.52-.32z"/><path d="M27 14.5C27 8.7 22.3 4 16.5 4S6 8.7 6 14.5c0 2.2.8 4.3 2.1 6L7 28l7.7-1.9c1.6.9 3.4 1.4 5.8 1.4 5.8 0 10.5-4.7 10.5-10.5zM16.5 26c-2 0-3.5-.5-5-.1L9 26l.3-2.4C8 22.1 7 19.5 7 16.5 7 9.6 12.6 4 19.5 4S32 9.6 32 16.5 26.4 26 19.5 26z"/></svg>
                    </a>
                    <a href="https://facebook.com" aria-label="Facebook" class="hover:text-gray-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.16 1.8.16v2h-1c-1 0-1.3.62-1.3 1.26V12h2.2l-.35 3h-1.85v7A10 10 0 0022 12z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <div class="font-bold text-gray-900">Clientes</div>
                <ul class="mt-3 space-y-2 text-gray-600">
                    <li><a href="#" class="hover:text-gray-900">Cómo usar Jobly</a></li>
                    <li><a href="{{ route('register') }}#register" class="hover:text-gray-900">Crear cuenta</a></li>
                    <li><a href="{{ route('offers.index') }}" class="hover:text-gray-900">Buscar servicios</a></li>
                    <li><a href="{{ route('offers.create') }}" class="hover:text-gray-900">Publicar oferta</a></li>
                </ul>
            </div>
            <div>
                <div class="font-bold text-gray-900">Profesionales</div>
                <ul class="mt-3 space-y-2 text-gray-600">
                    <li><a href="{{ route('register') }}#register" class="hover:text-gray-900">Regístrate como pro</a></li>
                    <li><a href="#" class="hover:text-gray-900">Recursos y consejos</a></li>
                    <li><a href="#" class="hover:text-gray-900">Reseñas</a></li>
                </ul>
            </div>
            <div>
                <div class="font-bold text-gray-900">Soporte</div>
                <ul class="mt-3 space-y-2 text-gray-600">
                    <li><a href="#" class="hover:text-gray-900">Ayuda</a></li>
                    <li><a href="#" class="hover:text-gray-900">Seguridad</a></li>
                    <li><a href="#" class="hover:text-gray-900">Términos</a></li>
                    <li><a href="#" class="hover:text-gray-900">Privacidad</a></li>
                </ul>
            </div>
        </div>
    </footer>
</x-guest-layout>
