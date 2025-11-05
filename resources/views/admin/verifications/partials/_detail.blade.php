@php
    /** @var \App\Models\IdentityVerification $verification */

    use Illuminate\Support\Facades\Storage;$vid = $verification->id;
    $gallery = [];
    if ($verification->dpi_front) $gallery[] = Storage::url($verification->dpi_front);
    if ($verification->selfie)    $gallery[] = Storage::url($verification->selfie);
    if ($verification->voucher)   $gallery[] = Storage::url($verification->voucher);

    $formattedDpi = $verification->dpi
        ? preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $verification->dpi)
        : '—';

    $fullNames = trim(($verification->user->first_name ?? '') . ' ' . ($verification->user->second_name ?? ''));
    $fullLastNames = trim(($verification->user->last_name ?? '') . ' ' . ($verification->user->second_last_name ?? ''));

    $formattedDate = optional($verification->user->profile->birth_date)
        ? \Carbon\Carbon::parse($verification->user->profile->birth_date)
            ->locale('es')
            ->isoFormat('DD [de] MMMM [de] YYYY')
        : '—';
@endphp


<div class="p-6" data-images='@json($gallery)' data-vid="{{ $vid }}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- === GALERÍA === --}}
        <div>
            <h4 class="font-semibold mb-2">Documentos del usuario</h4>

            <div class="glide" id="glide-{{ $vid }}">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($gallery as $idx => $img)
                            <li class="glide__slide">
                                <img src="{{ $img }}" class="cursor-pointer max-h-96 w-full rounded-lg object-contain"
                                     onclick="JV.open({{ $vid }}, {{ $idx }})">
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex justify-center gap-3 mt-2" data-glide-el="controls">
                    <button data-glide-dir="<" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">❮</button>
                    <button data-glide-dir=">" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">❯</button>
                </div>
            </div>

            {{-- VISOR --}}
            <div id="viewer-{{ $vid }}" class="hidden fixed inset-0 bg-black/80 z-[99999] items-center justify-center">
                <img id="viewer-img-{{ $vid }}"
                     class="max-h-[85vh] max-w-[90vw] rounded-lg cursor-zoom-in transition-transform"/>
                <button onclick="JV.close({{ $vid }})" class="absolute top-8 right-10 text-white text-3xl">×</button>
                <button onclick="JV.prev({{ $vid }})" class="absolute left-6 text-white text-3xl">❮</button>
                <button onclick="JV.next({{ $vid }})" class="absolute right-6 text-white text-3xl">❯</button>
            </div>

        </div>

        {{-- === CHECKLIST === --}}
        <div>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 font-medium">DPI:</td>
                    <td>{{ $formattedDpi }}</td>
                    <td class="text-right">
                        <label><input type="radio" name="dpi_ok"> Sí</label>
                        <label class="ml-3"><input type="radio" name="dpi_ok"> No</label>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 font-medium text-gray-600 w-32">Nombres:</td>
                    <td class="py-2">{{ $fullNames ?: '—' }}</td>
                    <td class="py-2 text-right whitespace-nowrap">
                        <label class="mr-3"><input type="radio" name="names_ok" value="yes"> Sí</label>
                        <label><input type="radio" name="names_ok" value="no"> No</label>
                    </td>
                </tr>

                <tr>
                    <td class="py-2 font-medium text-gray-600 w-32">Apellidos:</td>
                    <td class="py-2">{{ $fullLastNames ?: '—' }}</td>
                    <td class="py-2 text-right whitespace-nowrap">
                        <label class="mr-3"><input type="radio" name="lastnames_ok" value="yes"> Sí</label>
                        <label><input type="radio" name="lastnames_ok" value="no"> No</label>
                    </td>
                </tr>
                <tr>
                    <td class="py-1 font-medium">Fecha Nac:</td>
                    <td>{{ $formattedDate }}</td>
                    <td class="text-right">
                        <label><input type="radio" name="birth_ok"> Sí</label>
                        <label class="ml-3"><input type="radio" name="birth_ok"> No</label>
                    </td>
                </tr>
                @if($verification->voucher)
                    <tr>
                        <td class="py-1 font-medium">Ubicación:</td>
                        <td>{{ $verification->user->profile->department }}
                            / {{ $verification->user->profile->municipality }}</td>
                        <td class="text-right">
                            <label><input type="radio" name="loc_ok"> Sí</label>
                            <label class="ml-3"><input type="radio" name="loc_ok"> No</label>
                        </td>
                    </tr>
                @endif
            </table>

            {{-- Acciones --}}
            <form action="{{ route('admin.verifications.reject', $verification->id) }}" method="POST"
                  class="mt-4 space-y-3">
                @csrf
                <textarea name="rejection_reason" class="w-full border rounded-xl px-3 py-2"
                          placeholder="Motivo (opcional)"></textarea>
                <div class="flex justify-end gap-3">
                    <button class="btn-reject">Rechazar</button>
                    <button type="button" class="btn-approve" onclick="JV.approve({{ $verification->id }})">Aprobar
                    </button>
                </div>
            </form>

        </div>

    </div>
    <script>
        window.JVInit = function () {

            // Configurar galería de imágenes
            const galleries = document.querySelectorAll('[data-gallery]');
            galleries.forEach(gal => {
                const vid = gal.getAttribute('data-gallery');
                const images = JSON.parse(gal.getAttribute('data-images'));

                if (!window.JV) window.JV = {galleries: {}};
                window.JV.galleries[vid] = {images: images, idx: 0};

                // Montar Glide
                new Glide(`#glide-${vid}`, {
                    type: 'carousel',
                    startAt: 0,
                    perView: 1,
                    gap: 20,
                }).mount();
            });

            // Click para abrir visor
            document.querySelectorAll('[data-viewer-open]').forEach(btn => {
                btn.onclick = function () {
                    const vid = this.dataset.gallery;
                    const idx = parseInt(this.dataset.index);
                    window.JV.galleries[vid].idx = idx;

                    const viewer = document.getElementById(`viewer-${vid}`);
                    const img = document.getElementById(`viewer-img-${vid}`);
                    img.src = window.JV.galleries[vid].images[idx];
                    viewer.classList.remove('hidden');
                }
            });

            // Botones del visor
            document.querySelectorAll('[data-viewer-close]').forEach(btn => {
                btn.onclick = () => btn.closest('[data-viewer]').classList.add('hidden');
            });

            // Prev / Next
            document.querySelectorAll('[data-viewer-prev]').forEach(btn => {
                btn.onclick = () => {
                    const vid = btn.dataset.gallery;
                    const g = window.JV.galleries[vid];
                    g.idx = (g.idx - 1 + g.images.length) % g.images.length;
                    document.getElementById(`viewer-img-${vid}`).src = g.images[g.idx];
                };
            });

            document.querySelectorAll('[data-viewer-next]').forEach(btn => {
                btn.onclick = () => {
                    const vid = btn.dataset.gallery;
                    const g = window.JV.galleries[vid];
                    g.idx = (g.idx + 1) % g.images.length;
                    document.getElementById(`viewer-img-${vid}`).src = g.images[g.idx];
                };
            });
        };
    </script>
</div>
