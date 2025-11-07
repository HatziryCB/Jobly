<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Parámetros
        $query = $request->get('q');
        $category = $request->get('category');
        $status = $request->get('status');

        $categories = [
            'Limpieza', 'Pintura', 'Mudanza', 'Jardinería', 'Reparaciones', 'Electricidad',
            'Plomería', 'Cuidado de niños', 'Cuidado de adultos mayores',
            'Eventos', 'Mecánica', 'Construcción', 'Ayuda temporal', 'Asistencia'
        ];

        // Subconsulta: obtener último mensaje recibido del empleador
        $latestMessages = \App\Models\Message::selectRaw('MAX(created_at) as last_message, sender_id, receiver_id')
            ->where('receiver_id', $user->id)
            ->groupBy('sender_id', 'receiver_id');

        // Consulta principal
        $applications = \App\Models\Application::query()
            ->with('offer', 'offer.employer')
            ->where('employee_id', $user->id)
            ->leftJoinSub($latestMessages, 'messages', function ($join) {
                $join->on('applications.employee_id', '=', 'messages.receiver_id');
            })
            ->select('applications.*')
            ->when($query, fn($q) =>
            $q->whereHas('offer', fn($sub) =>
            $sub->where('title', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
            )
            )
            ->when($category, fn($q) =>
            $q->whereHas('offer', fn($sub) => $sub->where('category', $category))
            )
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('messages.last_message') // mensajes recientes primero
            ->latest('applications.created_at') // luego las más nuevas
            ->paginate(4)
            ->withQueryString();

        return view('employee.applications', compact('applications', 'q', 'category', 'status', 'categories'));
    }

    public function send(Request $request, $userId)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}

