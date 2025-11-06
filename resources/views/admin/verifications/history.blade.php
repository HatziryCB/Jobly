@extends('layouts.dashboard')

@section('title', 'Historial de solicitudes')

@section('dashboard-content')
    <h2 class="text-2xl font-semibold mb-6">Historial de solicitudes de verificación</h2>

    <form method="GET" class="flex flex-wrap items-end gap-4 mb-6">

        <div>
            <label class="text-sm text-gray-600 font-medium">Estado</label>
            <select name="status" class="border rounded-xl px-3 py-1.5 text-sm">
                <option value="">Todos</option>
                <option value="approved" @selected(request('status')==='approved')>Aprobadas</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rechazadas</option>
                <option value="expired" @selected(request('status')==='expired')>Expiradas</option>
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600 font-medium">Buscar usuario</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o correo"
                   class="border rounded-xl px-3 py-1.5 text-sm w-48">
        </div>

        <button class="bg-[var(--brand-primary)] text-white px-4 py-2 rounded-xl hover:bg-[var(--brand-secondary)] text-sm">
            <i class="fas fa-filter mr-1"></i> Filtrar
        </button>
    </form>

    <div class="overflow-x-auto bg-white shadow-md rounded-2xl border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Usuario</th>
                <th class="px-4 py-3">DPI</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Fecha</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($verifications as $v)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium">
                        {{ $v->user->first_name }} {{ $v->user->last_name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $v->dpi) }}
                    </td>

                    <td class="px-4 py-3">
                        @if($v->status === 'approved')
                            <span class="px-2 py-1 rounded-xl bg-green-100 text-green-800 text-xs font-semibold">Aprobada</span>
                        @elseif($v->status === 'rejected')
                            <span class="px-2 py-1 rounded-xl bg-red-100 text-red-800 text-xs font-semibold">Rechazada</span>
                        @else
                            <span class="px-2 py-1 rounded-xl bg-gray-200 text-gray-700 text-xs font-semibold">Expirada</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">{{ $v->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">No hay historial.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $verifications->links() }}</div>
@endsection
