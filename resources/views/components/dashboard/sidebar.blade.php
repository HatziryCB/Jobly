<aside class="w-64 bg-white border-r p-6">
    <div class="text-center mb-6">
        <img src="{{ auth()->user()->profile_photo_url ?? '/images/default-user.png' }}" class="w-16 h-16 rounded-full mx-auto">
        <p class="mt-2 font-semibold">{{ auth()->user()->full_name }}</p>
        @if(auth()->user()->is_verified)
            <p class="text-green-600 text-sm">✔ Verificado</p>
        @endif
    </div>

    <nav class="space-y-2">

        @role('admin')
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Mi Perfil</a>
        @endrole

        @role('employer')
        <a href="{{ route('employer.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Mi Perfil</a>
        <a href="{{ route('employer.offers') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Mis Ofertas</a>
        @endrole

        @role('employee')
        <a href="{{ route('employee.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Mi Perfil</a>
        <a href="{{ route('employee.applications') }}" class="block py-2 px-3 rounded hover:bg-gray-100">Mis Postulaciones</a>
        @endrole

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block py-2 px-3 rounded hover:bg-red-100 text-pink-900 w-full text-left">Cerrar Sesión</button>
        </form>
    </nav>
</aside>

