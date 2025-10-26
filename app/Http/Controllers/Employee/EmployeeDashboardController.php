<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $applications = Auth::user()
            ->applications()
            ->with('offer')
            ->latest()
            ->limit(5)
            ->get();

        return view('employee.dashboard', compact('applications'));
    }
}
