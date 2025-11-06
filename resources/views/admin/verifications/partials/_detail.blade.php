@php
    $vid = $verification->id;
    $gallery = [];

    use Illuminate\Support\Facades\Storage;

    if ($verification->dpi_front) $gallery[] = Storage::disk('public')->url($verification->dpi_front);
    if ($verification->selfie)    $gallery[] = Storage::disk('public')->url($verification->selfie);
    if ($verification->voucher)   $gallery[] = Storage::disk('public')->url($verification->voucher);


    $formattedDpi = preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $verification->dpi);

    $fullNames = trim(($verification->user->first_name ?? '') . ' ' . ($verification->user->second_name ?? ''));
    $fullLastNames = trim(($verification->user->last_name ?? '') . ' ' . ($verification->user->second_last_name ?? ''));
    $gender = $verification->user->profile->gender;
    $formattedDate = $verification->user->profile->birth_date
        ? \Carbon\Carbon::parse($verification->user->profile->birth_date)->locale('es')->isoFormat('DD [de] MMMM [de] YYYY')
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
                                <img src="{{ $img }}" class="cursor-pointer max-h-[550px] w-full rounded-lg object-contain"
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
                    <td class="py-1 font-medium">Género:</td>
                    <td>{{ $gender }}</td>
                    <td class="text-right">
                        <label><input type="radio" name="gender_ok"> Sí</label>
                        <label class="ml-3"><input type="radio" name="gender_ok"> No</label>
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
            <a href="{{ route('admin.verifications.user.history', $verification->user->id) }}"
               class="text-sm text-indigo-600 hover:text-indigo-800 underline">
                📚 Ver historial de verificaciones de este usuario
            </a>

            {{-- Acciones --}}
            @if($verification->status === 'pending')
                <form action="{{ route('admin.verifications.reject', $verification->id) }}" method="POST" class="mt-10 space-y-3">
                    @csrf
                    <textarea name="rejection_reason" class="w-full border rounded-xl px-3 py-2" placeholder="Motivo (opcional)"></textarea>

                    <div class="flex justify-end gap-3">
                        <button class="btn-reject">Rechazar</button>
                        <button type="button" class="btn-approve" onclick="JV.approve({{ $verification->id }})">Aprobar</button>
                    </div>
                </form>
            @else
                <div class="mt-10 border-t pt-4 text-center text-gray-600 text-sm">
                    <strong>Esta solicitud ya fue: </strong>

                    @if($verification->status === 'approved')
                        <span class="text-green-600 font-semibold">✔ Aprobada</span>
                    @elseif($verification->status === 'rejected')
                        <span class="text-red-600 font-semibold">✘ Rechazada</span>
                    @elseif($verification->status === 'expired')
                        <span class="text-gray-500">⏱ Expirada</span>
                    @endif
                    @if($verification->rejection_reason)
                        <p class="mt-2 italic">Motivo: "{{ $verification->rejection_reason }}"</p>
                    @endif
                </div>
            @endif

        </div>
    </div>
    <script>
        window.JV = {
            g: {},

            init() {
                document.querySelectorAll("[data-images]").forEach(el => {
                    const vid = el.dataset.vid;
                    const images = JSON.parse(el.dataset.images);

                    this.g[vid] = { imgs: images, idx: 0 };

                    new Glide(`#glide-${vid}`, {
                        type: 'carousel',
                        startAt: 0,
                        perView: 1,
                        gap: 20,
                    }).mount();
                });
            },

            open(vid, index) {
                this.g[vid].idx = index;
                const viewer = document.getElementById(`viewer-${vid}`);
                const img = document.getElementById(`viewer-img-${vid}`);
                img.src = this.g[vid].imgs[index];
                viewer.classList.remove('hidden');
                viewer.classList.add('flex');
            },

            close(vid) {
                document.getElementById(`viewer-${vid}`).classList.add('hidden');
            },

            next(vid) {
                const g = this.g[vid];
                g.idx = (g.idx + 1) % g.imgs.length;
                document.getElementById(`viewer-img-${vid}`).src = g.imgs[g.idx];
            },

            prev(vid) {
                const g = this.g[vid];
                g.idx = (g.idx - 1 + g.imgs.length) % g.imgs.length;
                document.getElementById(`viewer-img-${vid}`).src = g.imgs[g.idx];
            }
        };
    </script>
    <script>
        function verifyBeforeApprove(id) {
            const required = ['dpi_ok','names_ok','lastnames_ok','gender_ok','birth_ok','loc_ok'];
            let incomplete = false;

            required.forEach(name => {
                const yes = document.querySelector(`input[name="${name}"][value="yes"]:checked`);
                const no = document.querySelector(`input[name="${name}"][value="no"]:checked`);
                if(!yes && !no) incomplete = true;
            });

            if (incomplete) {
                alert("Por favor completa todos los campos de verificación antes de aprobar.");
                return;
            }

            // Enviar aprobación
            fetch(`/admin/verifications/${id}/approve`, {
                method:'POST',
                headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}' }
            }).then(()=>location.reload());
        }

        function verifyBeforeReject(id) {
            const reason = document.querySelector(`#reject-form-${id} textarea`).value.trim();
            if (reason === '') {
                alert("Debes ingresar un motivo para rechazar la solicitud.");
                return false; // evita envío
            }
            return true; // permite enviar
        }
    </script>

</div>
