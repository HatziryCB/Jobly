<aside class="w-64 bg-white border-r p-4 sm:p-6 rounded-xl shadow-lg transition-all duration-300">
    <div class="text-center mb-8">
        @php
            $profile = auth()->user()->profile;
        @endphp

        <img src="{{ $profile && $profile->profile_picture
            ? asset('storage/' . $profile->profile_picture)
            : asset('images/default-user.jpg') }}"
             alt="Foto de perfil"
             class="w-20 h-20 rounded-full object-cover border mx-auto" />

        <p class="mt-2 text-lg font-bold text-gray-800">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
        @if(auth()->user()->is_verified)
            <p class="text-green-600 text-sm font-semibold flex items-center justify-center mt-1">
                <i class="fa-solid fa-circle-check mr-1">
                </i> Verificado
            </p>
        @endif
    </div>

    <nav class="space-y-1">
        @php
            $activeClass = 'bg-indigo-600 text-white font-semibold shadow-md';
            $inactiveClass = 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700';
            $currentRoute = Route::currentRouteName();
        @endphp

        @role('admin')
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'admin.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-chart-line w-5 mr-3"></i> Dashboard
        </a>
        <a href="{{ route('profile.show', auth()->id()) }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'profile.show') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-user-gear w-5 mr-3"></i> Mi Perfil
        </a>
        @endrole

        @role('employer')
        <a href="{{ route('employer.dashboard') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'employer.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-chart-line w-5 mr-3"></i> Dashboard
        </a>
        <a href="{{ route('profile.show', auth()->id()) }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'profile.show') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-user-gear w-5 mr-3"></i> Mi Perfil
        </a>
        <a href="{{ route('employer.offers') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'employer.offers') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-briefcase w-5 mr-3"></i> Mis Ofertas
        </a>
        @endrole

        @role('employee')
        <a href="{{ route('employee.dashboard') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'employee.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-chart-line w-5 mr-3"></i> Dashboard
        </a>
        <a href="{{ route('profile.show', auth()->id()) }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'profile.show') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-user-gear w-5 mr-3"></i> Mi Perfil
        </a>
        <a href="{{ route('employee.applications') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'applications.index') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-file-contract w-5 mr-3"></i> Mis Postulaciones
        </a>
        @endrole
        <div class="pt-4 border-t border-gray-100 mt-4"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center py-2 px-3 rounded-xl hover:bg-red-50 text-red-600 font-semibold w-full text-left transition-all duration-150">
            <i class="fa-solid fa-right-from-bracket w-5 mr-3"></i> Cerrar Sesión
            </button>
        </form>
    </nav>
</aside>

