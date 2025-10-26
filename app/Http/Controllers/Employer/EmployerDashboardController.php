<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeOffers = $user->offers()->where('status', 'open')->count();
        $hiredOffers = $user->offers()->where('status', 'hired')->count();
        $applicationsReceived = Application::whereIn('offer_id', $user->offers->pluck('id'))->count();

        return view('employer.dashboard', compact('activeOffers', 'hiredOffers', 'applicationsReceived'));
    }
}
