@php
    $vid = $verification->id;
    $gallery = [];
    if ($verification->dpi_front) $gallery[] = asset('storage/'.$verification->dpi_front);
    if ($verification->selfie)    $gallery[] = asset('storage/'.$verification->selfie);
    if ($verification->voucher)   $gallery[] = asset('storage/'.$verification->voucher);

    $formattedDpi = preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $verification->dpi);
    $fullNames = trim(($verification->user->first_name ?? '') . ' ' . ($verification->user->second_name ?? ''));
    $fullLastNames = trim(($verification->user->last_name ?? '') . ' ' . ($verification->user->second_last_name ?? ''));
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
                <img id="viewer-img-{{ $vid }}" class="max-h-[85vh] max-w-[90vw] rounded-lg cursor-zoom-in transition-transform" />
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
                    <td class="py-1 font-medium">Nombres:</td>
                    <td>{{ $fullNames }}</td>
                    <td class="text-right">
                        <label><input type="radio" name="name_ok"> Sí</label>
                        <label class="ml-3"><input type="radio" name="name_ok"> No</label>
                    </td>
                </tr>
                <tr>
                    <td class="py-1 font-medium">Apellidos:</td>
                    <td>{{ $fullLastNames }}</td>
                    <td class="text-right">
                        <label><input type="radio" name="last_ok"> Sí</label>
                        <label class="ml-3"><input type="radio" name="last_ok"> No</label>
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
                        <td>{{ $verification->user->profile->department }} / {{ $verification->user->profile->municipality }}</td>
                        <td class="text-right">
                            <label><input type="radio" name="loc_ok"> Sí</label>
                            <label class="ml-3"><input type="radio" name="loc_ok"> No</label>
                        </td>
                    </tr>
                @endif
            </table>

            {{-- Acciones --}}
            <form action="{{ route('admin.verifications.reject', $verification->id) }}" method="POST" class="mt-4 space-y-3">
                @csrf
                <textarea name="rejection_reason" class="w-full border rounded-xl px-3 py-2" placeholder="Motivo (opcional)"></textarea>
                <div class="flex justify-end gap-3">
                    <button class="btn-reject">Rechazar</button>
                    <button type="button" class="btn-approve" onclick="JV.approve({{ $verification->id }})">Aprobar</button>
                </div>
            </form>

        </div>

    </div>

</div>
