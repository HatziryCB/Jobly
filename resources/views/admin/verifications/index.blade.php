@extends('layouts.dashboard')

@section('title', 'Gestión de verificaciones')

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Solicitudes de verificación</h2>

        <a href="{{ route('admin.verifications.history') }}"
           class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
            <i class="fas fa-clock mr-1"></i> Historial
        </a>
    </div>
    {{-- FILTROS --}}
    <form method="GET" class="flex flex-wrap items-end gap-4 mb-6">
        <div>
            <label class="text-sm text-gray-600 font-medium">Estado</label>
            <select name="status" class="border rounded-xl px-3 py-1.5 text-sm">
                <option value="">Todos</option>
                <option value="pending" @selected(request('status')==='pending')>Pendiente</option>
                <option value="approved" @selected(request('status')==='approved')>Aprobada</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rechazada</option>
                <option value="expired" @selected(request('status')==='expired')>Expirada</option>
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600 font-medium">Tipo</label>
            <select name="type" class="border rounded-xl px-3 py-1.5 text-sm">
                <option value="">Todos</option>
                <option value="identity" @selected(request('type')==='identity')>Identidad</option>
                <option value="full" @selected(request('type')==='full')>Identidad + Ubicación</option>
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600 font-medium">Desde</label>
            <input type="date" name="from" value="{{ request('from') }}" class="border rounded-xl px-3 py-1.5 text-sm">
        </div>

        <div>
            <label class="text-sm text-gray-600 font-medium">Hasta</label>
            <input type="date" name="to" value="{{ request('to') }}" class="border rounded-xl px-3 py-1.5 text-sm">
        </div>

        <div>
            <label class="text-sm text-gray-600 font-medium">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o correo" class="border rounded-xl px-3 py-1.5 text-sm w-48">
        </div>

        <button class="bg-[var(--brand-primary)] text-white px-4 py-2 rounded-xl hover:bg-[var(--brand-secondary)] text-sm">
            <i class="fas fa-filter mr-1"></i> Filtrar
        </button>
    </form>

    {{-- TABLA --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-2xl border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Usuario</th>
                <th class="px-4 py-3">DPI</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Tipo</th>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3 text-center"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($verifications as $verification)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium flex items-center gap-2">
                        {{ $verification->user->first_name }} {{ $verification->user->last_name }}
                        @php
                            $count = $verification->user->identityVerifications->count();
                        @endphp
                        @if($count > 1)
                            <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-lg">Cant. Solic. {{ $count }}</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">{{ preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $verification->dpi) }}</td>

                    <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-xl text-xs font-semibold
                        @if($verification->status==='pending') bg-yellow-100 text-yellow-800
                        @elseif($verification->status==='approved') bg-green-100 text-green-800
                        @elseif($verification->status==='rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-600 @endif">
                        {{ ucfirst($verification->statusLabel) }}
                    </span>
                    </td>
                    <td class="px-4 py-3">
                        @if ($verification->voucher)
                            <span class="text-purple-600 font-semibold">Identidad + Ubicación</span>
                        @else
                            <span class="text-blue-600 font-semibold">Identidad</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">{{ $verification->created_at->format('d/m/Y') }}</td>

                    <td class="px-4 py-3 text-center">
                        <button onclick="openModal({{ $verification->id }})"
                                class="text-indigo-600 hover:text-indigo-800 transition" title="Revisar">
                            <i class="fas fa-eye text-lg"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4 text-gray-500">No hay solicitudes.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $verifications->links() }}</div>

    {{-- MODAL --}}
    <div id="verificationModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-[9999] justify-center items-start pt-20">
        <div class="bg-white rounded-2xl shadow-2xl w-[95%] max-w-[1200px] max-h-[92vh] overflow-y-auto relative">
            {{-- Botón cerrar --}}
            <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-3xl font-bold leading-none">
                &times;
            </button>
            <div id="modalContent" class="p-6"></div>
        </div>
    </div>

    <script>
        async function openModal(id) {
            const modal = document.getElementById('verificationModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const response = await fetch(`/admin/verifications/${id}`);
            const data = await response.text();
            content.innerHTML = data;

            // Aquí se inicializa la galería
            JV.init();
        }

        function closeModal() {
            document.getElementById('verificationModal').classList.add('hidden');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>

    <script>
        window.JV = {
            g:{},

            init() {
                document.querySelectorAll("[data-images]").forEach(el=>{
                    let vid = el.dataset.vid;
                    this.g[vid] = {imgs: JSON.parse(el.dataset.images), idx:0};
                    new Glide(`#glide-${vid}`, {type:'carousel', perView:1}).mount();
                });
            },

            open(vid, i){
                this.g[vid].idx = i;
                let v = document.getElementById(`viewer-${vid}`);
                document.getElementById(`viewer-img-${vid}`).src = this.g[vid].imgs[i];
                v.classList.remove("hidden"); v.classList.add("flex");
            },
            close(vid){
                document.getElementById(`viewer-${vid}`).classList.add("hidden");
            },
            next(vid){
                let g = this.g[vid];
                g.idx = (g.idx+1)%g.imgs.length;
                document.getElementById(`viewer-img-${vid}`).src = g.imgs[g.idx];
            },
            prev(vid){
                let g = this.g[vid];
                g.idx = (g.idx-1+g.imgs.length)%g.imgs.length;
                document.getElementById(`viewer-img-${vid}`).src = g.imgs[g.idx];
            },
            approve(id){
                fetch(`/admin/verifications/${id}/approve`, {method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}})
                    .then(()=>location.reload());
            }
        };

        // Ejecutamos al abrir el modal
        document.addEventListener('verify:loaded', ()=>JV.init());
    </script>

@endsection
