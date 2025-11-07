<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Application;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Offer $offer)
    {
        // Solo el empleador dueño de la oferta puede ver los candidatos
        abort_unless(
            auth()->user()->hasRole('employer') && auth()->id() === $offer->employer_id,
            403
        );

        // Traemos las postulaciones con el perfil del empleado
        $applications = $offer->applications()
            ->with(['employee.profile'])
            ->orderByRaw("FIELD(status, 'accepted', 'pending', 'rejected')")
            ->get();

        // Mostramos por defecto el primer candidato en el panel derecho
        $selectedApplication = $applications->first();
        $selectedCandidate = $selectedApplication?->employee;

        return view('applications.candidates', compact(
            'offer',
            'applications',
            'selectedApplication',
            'selectedCandidate'
        ));
    }

    public function show(Offer $offer, $employeeId)
    {
        abort_unless(
            auth()->user()->hasRole('employer') && auth()->id() === $offer->employer_id,
            403
        );

        $application = $offer->applications()
            ->where('employee_id', $employeeId)
            ->with('employee.profile')
            ->firstOrFail();

        $selectedCandidate = $application->employee;

        // Renderizamos solo el panel derecho
        return view('applications.partials._candidate_detail', compact(
            'offer',
            'application',
            'selectedCandidate'
        ));
    }


}
