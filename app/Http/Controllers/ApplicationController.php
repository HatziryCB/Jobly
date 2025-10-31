<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Offer $offer)
    {
        $user = auth()->user();

        // Verifica que solo empleados puedan postular
        if (!$user->hasRole('employee')) {
            abort(403, 'Solo los empleados pueden postular a ofertas.');
        }
        // Validación (mensaje opcional)
        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        // Verifica si ya se postuló
        $alreadyApplied = Application::where('offer_id', $offer->id)
            ->where('employee_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Ya te has postulado a esta oferta.');
        }
        // Crea la postulación
        Application::create([
            'offer_id' => $offer->id,
            'employee_id' => $user->id,
            'message' => $data['message'] ?? null,
        ]);
        return redirect()->route('applications.index')->with('success', '¡Postulación enviada exitosamente!');
    }

    public function index()
    {
        $user = auth()->user();
        $applications = Application::with('offer')
            ->where('employee_id', $user->id)
            ->latest()
            ->get();
        return view('applications.index', compact('applications'));
    }
    public function accept(Application $application)
    {
        //$this->authorize('update', $application->offer);
        $application->status = 'accepted';
        $application->save();
        // Cambia estado de la oferta a "hired"
        $application->offer->update(['status' => 'hired']);
        return redirect()->back()->with('success', 'Candidato aceptado y oferta marcada como contratada.');
    }

}
