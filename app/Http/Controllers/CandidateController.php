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
        abort_unless(auth()->user()->hasRole('employer') && auth()->id() === $offer->employer_id, 403);

        $applications = $offer->applications()->with(['employee.profile'])->get();

        return view('applications.candidates', compact('offer', 'applications'));
    }

    public function show(Offer $offer, $employeeId)
    {
        abort_unless(auth()->user()->hasRole('employer') && auth()->id() === $offer->employer_id, 403);

        $application = $offer->applications()
            ->where('employee_id', $employeeId)
            ->with('employee.profile')
            ->firstOrFail();

        return view('offers.candidate_detail', compact('application'));
    }
}
