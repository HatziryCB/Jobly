<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Offer;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $applicationsMade = Application::where('employee_id', $user->id)->count();
        $applicationsProcessed = Application::where('employee_id', $user->id)
            ->whereIn('status', ['accepted', 'rejected'])
            ->count();
        $applicationsRejected = Application::where('employee_id', $user->id)
            ->where('status', 'rejected')
            ->count();

        // Recomendaciones simples: otras ofertas abiertas que no ha postulado aún
        $recommendedOffers = Offer::where('status', 'open')
            ->whereNotIn('id', Application::where('employee_id', $user->id)->pluck('offer_id'))
            ->latest()->take(5)->get();

        return view('employee.dashboard', compact(
            'applicationsMade',
            'applicationsProcessed',
            'applicationsRejected',
            'recommendedOffers'
        ));
    }
}
