<header x-data="{ open: false }" class="w-full bg-white/90 backdrop-blur border-b z-[100] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/jobly-sf.png') }}" alt="Jobly" class="h-15 w-20">
        </a>

        <!-- Botón móvil -->
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

        <!-- Menú móvil mejorado -->
        <div
            x-show="open"
            x-transition
            class="absolute top-16 left-0 w-full bg-white shadow-md border-t z-50 md:hidden"
        >
            <div class="px-6 py-4 space-y-3 text-sm">

                {{-- Enlaces públicos visibles para todos --}}
                <a href="{{ route('offers.index') }}" class="block text-gray-700">Explorar ofertas</a>
                <a href="{{ route('categories') }}" class="block text-gray-700">Categorías</a>

                {{-- Submenú: Sobre Jobly --}}
                <div x-data="{ submenu: false }">
                    <button @click="submenu = !submenu" class="w-full text-left text-gray-700 flex items-center justify-between">
                        Sobre Jobly
                        <svg :class="{ 'rotate-180': submenu }" class="w-4 h-4 transform transition-transform" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                    </button>
                    <div x-show="submenu" class="pl-4 space-y-1" x-transition>
                        <a href="#como-funciona" class="block text-gray-600">Cómo funciona</a>
                        <a href="#beneficios" class="block text-gray-600">Beneficios</a>
                        <a href="#populares" class="block text-gray-600">Proyectos populares</a>
                    </div>
                </div>

                @auth
                    {{-- Menú del usuario logueado --}}
                    <div x-data="{ userMenu: false }" class="pt-2 border-t">
                        <button @click="userMenu = !userMenu"
                                class="w-full text-left text-gray-700 font-medium flex items-center justify-between">
                            {{ Str::title(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}
                            <svg :class="{ 'rotate-180': userMenu }" class="w-4 h-4 transform transition-transform" fill="currentColor">
                                <path d="M5.25 7.5L10 12.25 14.75 7.5z" />
                            </svg>
                        </button>

                        <div x-show="userMenu" class="pl-4 space-y-1 mt-2" x-transition>

                            @role('employer')
                            <a href="{{ route('employer.dashboard') }}" class="block text-gray-700">Panel</a>
                            <a href="{{ route('profile.show', auth()->id()) }}" class="block text-gray-700">Mi perfil</a>
                            <a href="{{ route('employer.offers') }}" class="block text-gray-700">Mis ofertas</a>

                            @elserole('employee')
                            <a href="{{ route('employee.dashboard') }}" class="block text-gray-700">Panel</a>
                            <a href="{{ route('profile.show', auth()->id()) }}" class="block text-gray-700">Mi perfil</a>
                            <a href="{{ route('applications.index') }}" class="block text-gray-700">Mis postulaciones</a>
                            @endrole

                            @role('admin')
                            <a href="{{ route('admin.dashboard') }}" class="block text-gray-700">Panel administrativo</a>
                            <a href="{{ route('profile.show', auth()->id()) }}" class="block text-gray-700">Mi perfil</a>
                            @endrole

                            <span class="block text-gray-400 cursor-not-allowed">Reportes (próximamente)</span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left text-red-600">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>

                @else
                    {{-- Usuario no autenticado --}}
                    <a href="{{ route('login') }}" class="block text-gray-700">Ingresar</a>
                    <a href="{{ route('register') }}"
                       class="inline-block px-4 py-2 text-sm font-semibold bg-[var(--brand-primary)] text-white rounded-full">
                        Crear cuenta
                    </a>
                @endauth

            </div>
        </div>

        <!-- Navegación escritorio -->
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-gray-900">Explorar ofertas</a>

            @role('employer')
            <a href="{{ route('offers.create') }}" class="text-gray-700 hover:text-gray-900">Publicar</a>
            @endrole

            <a href="{{ route('categories') }}" class="text-gray-700 hover:text-gray-900">Categorías</a>

            <!-- Sobre Jobly -->
            <div x-data="{ open: false }" class="relative" x-cloak>
                <button @click="open = !open" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                    Sobre Jobly
                    <svg class="w-4 h-4" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                </button>
                <div x-show="open" @click.outside="open = false"
                     class="absolute mt-2 w-48 bg-white shadow rounded p-2 z-[100]">
                    <a href="#como-funciona" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Cómo funciona</a>
                    <a href="#beneficios" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Beneficios</a>
                    <a href="#populares" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Proyectos populares</a>
                </div>
            </div>

            @auth
                <!-- Menú Usuario -->
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <button @click="open = !open" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                        {{ Str::title(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}
                        <svg class="w-4 h-4" fill="currentColor"><path d="M5.25 7.5L10 12.25 14.75 7.5z" /></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         class="absolute mt-2 w-56 bg-white shadow rounded p-2 z-[100]">

                        @role('employer')
                        <a href="{{ route('employer.dashboard') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Panel</a>
                        <a href="{{ route('profile.show', auth()->id()) }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mi perfil</a>
                        <a href="{{ route('employer.offers') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mis ofertas</a>

                        @elserole('employee')
                        <a href="{{ route('employee.dashboard') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Panel</a>
                        <a href="{{ route('profile.show', auth()->id()) }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mi perfil</a>
                        <a href="{{ route('applications.index') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mis postulaciones</a>
                        @endrole

                        @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Admin</a>
                        <a href="{{ route('profile.show', auth()->id()) }}" class="block px-3 py-2 hover:bg-gray-50 text-gray-700">Mi perfil</a>
                        @endrole

                        <a href="#" class="block px-3 py-2 hover:bg-gray-50 text-gray-400 cursor-not-allowed">Reportes (próximamente)</a>

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
</header>
