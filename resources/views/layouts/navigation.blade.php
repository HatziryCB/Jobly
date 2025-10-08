<header class="w-full bg-white/90 backdrop-blur border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/jobly-sf.png') }}" alt="Jobly" class="h-15 w-20">
        </a>

        <nav class="hidden md:flex items-center gap-6">

            <a href="{{ route('offers.create') }}" class="text-gray-700 hover:text-gray-900">Publicar</a>
            <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-gray-900">Explorar ofertas</a>

            {{-- Dropdown: Servicios --}}
            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="text-gray-700 hover:text-gray-900 inline-flex items-center gap-1">
                    Servicios
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.25 7.5L10 12.25 14.75 7.5z"/></svg>
                </button>
                <div x-show="open" @click.outside="open=false"
                     class="absolute z-50 mt-2 w-56 bg-white shadow-lg rounded-lg p-2">
                    @foreach (['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería'] as $c)
                        <a href="{{ route('offers.index',['q'=>$c]) }}"
                           class="block px-3 py-2 rounded hover:bg-gray-50 text-gray-700">{{ $c }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Dropdown: Sobre Jobly --}}
            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="text-gray-700 hover:text-gray-900 inline-flex items-center gap-1">
                    Sobre Jobly
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.25 7.5L10 12.25 14.75 7.5z"/></svg>
                </button>
                <div x-show="open" @click.outside="open=false"
                     class="absolute z-50 mt-2 w-56 bg-white shadow-lg rounded-lg p-2">
                    <a href="#como-funciona" class="block px-3 py-2 rounded hover:bg-gray-50 text-gray-700">Cómo funciona</a>
                    <a href="#beneficios" class="block px-3 py-2 rounded hover:bg-gray-50 text-gray-700">Beneficios</a>
                    <a href="#populares" class="block px-3 py-2 rounded hover:bg-gray-50 text-gray-700">Proyectos populares</a>
                </div>
            </div>

            {{-- Auth CTAs --}}
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Ingresar</a>
            <a href="{{ route('register') }}"
               class="px-4 py-2 rounded-full font-semibold"
               style="background:#6C5CE7; color:#fff; border:2px solid #6C5CE7">Crear cuenta</a>
        </nav>
    </div>
</header>

