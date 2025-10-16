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
