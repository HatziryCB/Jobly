<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Application;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    // Mostrar todos los candidatos para una oferta
    public function index($offerId)
    {
        $offer = Offer::with(['applications.user.profile'])->findOrFail($offerId);

        // Asegurar que solo el empleador dueño de la oferta vea a los candidatos
        abort_unless(auth()->user()->hasRole('employer') && $offer->employer_id === auth()->id(), 403);

        $candidates = $offer->applications->map(function ($application) {
            $user = $application->user;
            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'verification_status' => $user->profile->verification_status ?? 'pending',
                'average_rating' => $user->profile->average_rating ?? 0,
                'department' => $user->profile->department ?? '',
                'municipality' => $user->profile->municipality ?? '',
                'application_id' => $application->id,
            ];
        });

        return view('offers.candidates', compact('offer', 'candidates'));
    }

    // Mostrar detalle del candidato seleccionado
    public function show($offerId, $candidateId)
    {
        $offer = Offer::findOrFail($offerId);
        $candidate = User::with('profile')->findOrFail($candidateId);

        abort_unless(auth()->user()->hasRole('employer') && $offer->employer_id === auth()->id(), 403);

        return response()->json([
            'user' => $candidate,
            'profile' => $candidate->profile
        ]);
    }
}
