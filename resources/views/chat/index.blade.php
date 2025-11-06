@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6 flex flex-col h-[75vh]">

        <h2 class="text-xl font-semibold mb-4">Chat con {{ $receiver->first_name }} {{ $receiver->last_name }}</h2>

        <div id="chatBox" class="flex-1 overflow-y-auto space-y-3 p-2 border rounded-lg bg-gray-50">
            @foreach($messages as $m)
                <div class="flex {{ $m->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="px-4 py-2 rounded-xl text-sm max-w-xs
                    {{ $m->sender_id == auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                        {{ $m->body }}
                    </div>
                </div>
            @endforeach
        </div>

        <form id="chatForm" class="flex mt-4">
            <input type="text" name="body" id="messageInput"
                   class="flex-1 border rounded-xl px-3 py-2 focus:ring-indigo-300"
                   placeholder="Escribe un mensaje...">
            <button class="ml-3 px-4 py-2 bg-indigo-600 text-white rounded-xl">Enviar</button>
        </form>
    </div>

    <script>
        document.getElementById('chatForm').addEventListener('submit', async function(e){
            e.preventDefault();

            const body = document.getElementById('messageInput').value;

            const res = await fetch("{{ route('chat.send', $receiver->id) }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ body })
            });

            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;

            if(res.ok){
                location.reload();
            }
        });
    </script>
@endsection
