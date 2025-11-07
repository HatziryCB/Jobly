<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(User $user)
    {
        $auth = auth()->user();

        // Si intentan hablar consigo mismos
        if ($auth->id === $user->id) {
            abort(403, 'No puedes hablar contigo mismo.');
        }

        // Caso A: Auth es EMPLEADOR y quiere hablar con un candidato
        $employerCanChat = \App\Models\Application::whereHas('offer', function($q) use ($auth) {
            $q->where('employer_id', $auth->id);
        })
            ->where('employee_id', $user->id)
            ->exists();

        // Caso B: Auth es EMPLEADO y quiere hablar con un empleador
        $employeeCanChat = \App\Models\Application::where('employee_id', $auth->id)
            ->whereHas('offer', function($q) use ($user) {
                $q->where('employer_id', $user->id);
            })
            ->exists();

        // Si NO se cumple ninguna relación válida → bloquear
        if (!$employerCanChat && !$employeeCanChat) {
            abort(403, 'No tienes permisos para hablar con este usuario.');
        }

        // Obtener mensajes
        $messages = \App\Models\Message::where(function($query) use ($auth, $user) {
            $query->where('sender_id', $auth->id)
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function($query) use ($auth, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $auth->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('chat.index', [
            'receiver' => $user,
            'messages' => $messages,
        ]);
    }

    public function send(Request $request, $userId)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'body' => $request->body,
        ]);

        return response()->json(['success' => true]);
    }
}

