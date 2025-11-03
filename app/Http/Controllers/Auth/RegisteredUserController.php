<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // VALIDACIONES
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'second_name' => ['nullable', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'second_last_name'  => ['nullable', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'phone'      => ['nullable', 'digits:8'],
            'role'       => ['required', Rule::in(['employee', 'employer'])],
            'password'   => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()            // mayúsculas y minúsculas
                    ->letters()              // letras
                    ->numbers()              // números
                    ->symbols()              // símbolos
            ],
            'terms'      => ['accepted'],
        ]);
        $user = User::create([
            'first_name'        => ucfirst(strtolower($validated['first_name'])),
            'second_name'       => isset($validated['second_name']) ? ucfirst(strtolower($validated['second_name'])) : null,
            'last_name'         => ucfirst(strtolower($validated['last_name'])),
            'second_last_name'  => isset($validated['second_last_name']) ? ucfirst(strtolower($validated['second_last_name'])) : null,
            'email'             => strtolower($validated['email']),
            'phone'             => $validated['phone'] ?? null,
            'password'          => Hash::make($validated['password']),
            'tos_accepted'      => true,
            'tos_accepted_at'   => now(),
        ]);

        // ASIGNAR ROL CON SPATIE
        $user->assignRole($request->input('role'));

        // EVENTO DE REGISTRO Y AUTENTICACIÓN
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
    private function redirectToRole(User $user)
    {
        if ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        }
        if ($user->hasRole('employee')) {
            return redirect()->route('employee.dashboard');
        }
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('offers.index');
    }

}
