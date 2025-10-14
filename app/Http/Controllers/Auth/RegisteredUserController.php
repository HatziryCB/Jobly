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

    public function store(Request $request)
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
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'] ?? null,
            'role'            => $validated['role'],
            'tos_accepted'    => true,
            'tos_accepted_at' => now(),
            'password'        => bcrypt($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirección por rol
        return redirect()->intended(
            $user->role === 'employer' ? route('offers.create') : route('offers.index')
        );
    }
}
