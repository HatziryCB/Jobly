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

                {{-- Buscador (ancho corregido) --}}
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
                <div class="relative z-map">
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
