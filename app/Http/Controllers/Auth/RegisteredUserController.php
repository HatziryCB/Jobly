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
            'second_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'second_last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
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

        // CREACIÓN DE USUARIO
        $user = User::create([
            'first_name'        => ucfirst(strtolower($validated['first_name'])),
            'second_name'        => ucfirst(strtolower($validated['second_name'])),
            'last_name'         => ucfirst(strtolower($validated['last_name'])),
            'second_last_name'         => ucfirst(strtolower($validated['second_last_name'])),
            'email'             => strtolower($validated['email']),
            'phone'             => $validated['phone'],
            'password'          => Hash::make($validated['password']),
            'tos_accepted'      => true,
            'tos_accepted_at'   => now(),
        ]);
        // ASIGNAR ROL CON SPATIE
        $user->assignRole($request->input('role'));

        // EVENTO DE REGISTRO Y AUTENTICACIÓN
        event(new Registered($user));
        Auth::login($user);

        // REDIRECCIÓN SEGÚN ROL
        return redirect()->intended(
            $validated['role'] === 'employer'
                ? route('offers.create')
                : route('offers.index')
        );
    }
}
