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
