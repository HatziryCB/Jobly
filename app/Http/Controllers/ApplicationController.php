<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Offer $offer) {
        abort_unless(Auth::check() && Auth::user()->hasRole('employee'), 403, 'Solo empleados pueden postular.');

        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        Application::firstOrCreate(
            ['offer_id' => $offer->id, 'employee_id' => Auth::id()],
            ['message' => $data['message'] ?? null]
        );

        return back()->with('status', 'Postulación enviada.');
    }

    public function accept(Application $application) {
        abort_unless(Auth::id() === $application->offer->employer_id, 403);

        $application->update([
            'status' => 'accepted',
            'accepted_at' => now()
        ]);

        $application->offer->update([
            'status' => 'hired'
        ]);

        return back()->with('status', 'Postulante aceptado y oferta marcada como contratada.');
    }
}
