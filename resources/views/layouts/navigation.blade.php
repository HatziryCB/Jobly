<header x-data="{ open: false }" class="w-full bg-white/90 backdrop-blur border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/jobly-sf.png') }}" alt="Jobly" class="h-15 w-20">
        </a>

        <!-- Botón hamburguesa móvil -->
        <button @click="open = !open" class="md:hidden text-gray-600 focus:outline-none">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Navegación escritorio -->
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-gray-900">Explorar ofertas</a>
            <a href="{{ route('offers.create') }}" class="text-gray-700 hover:text-gray-900">Publicar</a>

            {{-- Dropdown Servicios --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                    Servicios
                    <svg class="w-4 h-4" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                </button>
                <div x-show="open" @click.outside="open=false" class="absolute z-50 mt-2 w-48 bg-white shadow rounded p-2">
                    @foreach (['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería'] as $c)
                        <a href="{{ route('offers.index',['q'=>$c]) }}"
                           class="block px-3 py-2 rounded hover:bg-gray-50 text-gray-700">{{ $c }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Sobre Jobly --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                    Sobre Jobly
                    <svg class="w-4 h-4" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                </button>
                <div x-show="open" @click.outside="open=false" class="absolute z-50 mt-2 w-48 bg-white shadow rounded p-2">
                    <a href="#como-funciona" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Cómo funciona</a>
                    <a href="#beneficios" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Beneficios</a>
                    <a href="#populares" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Proyectos populares</a>
                </div>
            </div>

            @auth
                {{-- Dropdown Usuario --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                        {{ Str::limit(auth()->user()->name, 15) }}
                        <svg class="w-4 h-4" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                    </button>
                    <div x-show="open" @click.outside="open=false"
                         class="absolute z-50 mt-2 w-48 bg-white shadow rounded p-2">
                        <a href="#" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mi perfil</a>
                        <a href="{{ route('offers.index') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Ofertas</a>
                        <a href="{{ route('applications.index') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Postulaciones</a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-red-600 hover:bg-gray-50">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Ingresar</a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 rounded-full font-semibold bg-[var(--brand-primary)] text-white border-2 border-[var(--brand-primary)]">
                    Crear cuenta
                </a>
            @endauth
        </nav>
    </div>

    <!-- Menú móvil -->
    <div x-show="open" class="md:hidden px-4 pb-4 space-y-2">
        <a href="{{ route('offers.index') }}" class="block text-gray-700">Explorar ofertas</a>
        <a href="{{ route('offers.create') }}" class="block text-gray-700">Publicar</a>

        <div>
            <span class="block font-semibold text-gray-600">Servicios</span>
            @foreach (['Limpieza','Pintura','Mudanza','Jardinería','Reparaciones','Electricidad','Plomería'] as $c)
                <a href="{{ route('offers.index',['q'=>$c]) }}" class="block text-gray-700 pl-4 py-1">{{ $c }}</a>
            @endforeach
        </div>

        <div>
            <span class="block font-semibold text-gray-600">Sobre Jobly</span>
            <a href="#como-funciona" class="block text-gray-700 pl-4 py-1">Cómo funciona</a>
            <a href="#beneficios" class="block text-gray-700 pl-4 py-1">Beneficios</a>
            <a href="#populares" class="block text-gray-700 pl-4 py-1">Proyectos populares</a>
        </div>

        @auth
            <a href="#" class="block text-gray-700">Mi perfil</a>
            <a href="{{ route('offers.index') }}" class="block text-gray-700">Ofertas</a>
            <a href="{{ route('applications.index') }}" class="block text-gray-700">Postulaciones</a>
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-700">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-600">Cerrar sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-gray-700">Ingresar</a>
            <a href="{{ route('register') }}"
               class="inline-block w-auto bg-[var(--brand-primary)] text-white text-center rounded-xl px-4 py-2 mt-2">
                Crear cuenta
            </a>
        @endauth
    </div>
</header>
