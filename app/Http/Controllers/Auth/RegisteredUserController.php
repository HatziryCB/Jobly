<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone'                 => ['nullable', 'regex:/^[2-7]{1}[0-9]{7}$/'],
            'role'                  => ['required', Rule::in(['employee','employer'])],
            'password'              => ['required', 'confirmed',
                                        Password::min(8)
                                            ->mixedCase()
                                            ->numbers()
                                            ->symbols()
                                            ->uncompromised(),],
            'terms'                 => ['accepted'], // checkbox
        ]);

        $user = User::create([
            'first_name'      => $validated['first_name'],
            'last_name'       => $validated['last_name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'] ?? null,
            'password'        => bcrypt($validated['password']),
            'tos_accepted'    => true,
            'tos_accepted_at' => now(),
        ]);

        $user->assignRole($validated['role']);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(
            $user->hasRole('employer') ? route('dashboard.employer') : route('dashboard.employee')
        );
    }

}
