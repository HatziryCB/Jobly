@extends('layouts.dashboard')

@section('title', 'Chat')

@section('dashboard-content')

    <h2 class="text-xl font-semibold mb-4">
        {{ $receiver->first_name }} {{ $receiver->last_name }}
    </h2>

    <div class="bg-white rounded-2xl border p-4 h-[60vh] overflow-y-auto mb-4">
        @forelse($messages as $msg)
            <div class="mb-2 flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="{{ $msg->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }} px-3 py-2 rounded-xl max-w-[70%]">
                    <div class="text-sm">{{ $msg->body }}</div>
                    <div class="text-[10px] opacity-70 mt-1">{{ $msg->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Aún no hay mensajes.</p>
        @endforelse
    </div>

    <form action="{{ route('chat.send', $receiver->id) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="body" class="flex-1 border rounded-xl px-3 py-2" placeholder="Escribe un mensaje..." required>
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl">Enviar</button>
    </form>

@endsection
