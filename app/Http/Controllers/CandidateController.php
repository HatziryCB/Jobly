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
        $candidates = $offer->applications()
            ->with(['employee.profile'])
            ->orderByRaw("FIELD(status, 'accepted', 'pending', 'rejected')")
            ->get();

        $application = $offer->applications()
            ->where('employee_id', $employeeId)
            ->with('employee.profile')
            ->firstOrFail();

        return view('applications.candidate_detail', compact('offer', 'application'));

    }

    public function show(Offer $offer, $employeeId)
    {
        //
    }

}
