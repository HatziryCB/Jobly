<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        //$this->authorize('view', $user); // si usas policies, opcional
        $user->load('profile');

        return view('profile.show', compact('user'));
    }
    public function edit(User $user)
    {
        //$this->authorize('update', $user);
        $user->load('profile');

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:8',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:2000',
            'department' => 'nullable|string|max:80',
            'municipality' => 'nullable|string|max:80',
            'zone' => 'nullable|string|max:80',
            'neighborhood' => 'nullable|string|max:80',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user->update([
            'first_name' => ucfirst($validated['first_name']),
            'second_name' => ucfirst($validated['second_name'] ?? ''),
            'last_name' => ucfirst($validated['last_name']),
            'second_last_name' => ucfirst($validated['second_last_name'] ?? ''),
            'phone' => $validated['phone'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $filename = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile->profile_picture = $filename;
        }

        $user->profile->fill($validated)->save();

        return redirect()->route('profile.show', $user)->with('success', 'Perfil actualizado correctamente');
    }
}
