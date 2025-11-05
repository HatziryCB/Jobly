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

        <div class="flex items-center gap-2">
            <span class="font-medium text-gray-800 mx-auto mt-4">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            @if (Auth::user()->profile && Auth::user()->profile->verification_status === 'verified')
                <img src="{{ asset('images/verified-badge.png') }}" alt="Verificado" class="h-4 w-4">
            @endif
        </div>
        <span class="font-light text-gray-500 mx-auto">{{ Auth::user()->email }}</span>
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
        <a href="{{ route('admin.verifications.index') }}"
           class="flex items-center py-2 px-3 rounded-xl transition-all duration-150 {{ str_contains($currentRoute, 'admin.verifications.index') ? $activeClass : $inactiveClass }}">
            <i class="fa-solid fa-chart-line w-5 mr-3"></i> Solicitudes
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

