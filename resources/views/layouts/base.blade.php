<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Jobly')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
<body class="bg-[var(--bg)] min-h-screen flex flex-col">
@include('layouts.navigation')

    <main class="flex-grow flex items-center justify-center px-4 py-10">
        <div class="@yield('card-max-w','w-full max-w-5xl') bg-white rounded-3xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-3">
            @yield('content-wrapper')

                {{-- Imagen 1/3 --}}
                <div class="hidden md:block col-span-1 relative">
                    <img src="https://images.unsplash.com/photo-1657185140919-db37897e0fd5?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                         alt="Trabajo temporal"
                         class="w-full h-full object-cover" />
                </div>

                {{-- Formulario 2/3 --}}
                <div class="col-span-2 p-6 md:p-10 flex flex-col justify-center">
                    {{-- Logo y título --}}
                    <div class="text-center">
                        <h1 class="text-2xl md:text-2xl font-bold text-[var(--text)] my-5">@yield('form-title')</h1>
                    </div>

                    {{-- Contenido dinámico (el formulario) --}}
                    @yield('content')
                </div>
            </div>
    </main>
</body>
</html>
