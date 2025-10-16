<section class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Personas que confían en Jobly</h2>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ([['Ana','“Muy rápida la contratación.”',5],['Luis','“Encontré trabajo en un día.”',4],['María','“Me sentí segura con perfiles verificados.”',5]] as $t)
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="font-bold text-gray-900 mb-1">{{ $t[0] }}</div>
                    <div class="flex gap-1 mb-2">
                        @for ($i=0; $i<5; $i++)
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="{{ $i < $t[2] ? '#F59E0B' : '#E5E7EB' }}"><path d="M10 15l-5.878 3.09L5.7 11.545.822 7.41l6.364-.925L10 1l2.814 5.485 6.364.925-4.878 4.135 1.578 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600">{{ $t[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
