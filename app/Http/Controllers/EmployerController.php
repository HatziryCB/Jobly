<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function show(User $employer)
    {
        abort_unless($employer->hasRole('employer'), 404);

        $profile = $employer->profile;

        return view('employer.show', compact('employer', 'profile'));
    }
}
