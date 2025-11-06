@extends('layouts.dashboard')

@section('title', 'Historial de Verificaciones')

@section('dashboard-content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">
            Historial de verificaciones — <span class="text-[var(--brand-primary)]">{{ $user->first_name }} {{ $user->last_name }}</span>
        </h2>

        <a href="{{ route('admin.verifications.index') }}"
           class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
            ← Volver
        </a>
    </div>

    {{-- FILTROS --}}
    <form method="GET" class="flex flex-wrap items-end gap-4 mb-5">

        <div>
            <label class="text-sm text-gray-600 font-medium">Estado</label>
            <select name="status" class="border rounded-xl px-3 py-1.5 text-sm">
                <option value="">Todos</option>
                <option value="approved" @selected(request('status')==='approved')>Aprobados</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rechazados</option>
                <option value="expired" @selected(request('status')==='expired')>Expirados</option>
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

        <button class="bg-[var(--brand-primary)] text-white px-4 py-2 rounded-xl hover:bg-[var(--brand-secondary)] text-sm">
            <i class="fas fa-filter mr-1"></i> Filtrar
        </button>
    </form>

    {{-- TABLA --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-2xl border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">DPI</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Motivo (si rechazado)</th>
            </tr>
            </thead>
            <tbody>
            @forelse($verifications as $v)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $v->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">{{ preg_replace('/(\d{4})(\d{5})(\d{4})/', '$1 $2 $3', $v->dpi) }}</td>
                    <td class="px-4 py-3 capitalize">
                        @if($v->status === 'approved')
                            <span class="px-2 py-1 rounded-xl bg-green-100 text-green-800 text-xs font-semibold">Aprobada</span>
                        @elseif($v->status === 'rejected')
                            <span class="px-2 py-1 rounded-xl bg-red-100 text-red-800 text-xs font-semibold">Rechazada</span>
                        @else
                            <span class="px-2 py-1 rounded-xl bg-gray-100 text-gray-700 text-xs font-semibold">Expirada</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $v->rejection_reason ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">No hay registros.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
