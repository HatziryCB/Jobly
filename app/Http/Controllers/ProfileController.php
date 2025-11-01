<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->loadMissing('profile');
        if (!$user->profile) {
            $user->profile()->create();
            $user->refresh();
        }

        return view('profile.show', compact('user'));
    }
    public function edit(User $user)
    {
        $profile = $user->profile ?? $user->profile()->create();
        $categories = [
            'Limpieza',
            'Pintura',
            'Mudanza',
            'Jardinería',
            'Reparaciones',
            'Electricidad',
            'Plomería',
            'Cuidado de niños',
            'Cuidado de adultos mayores',
            'Eventos',
            'Mecánica',
            'Construcción',
            'Ayuda temporal',
            'Asistencia'
        ];

        return view('profile.edit', [
            'profile' => $profile,
            'categories' => $categories,
            'user' => $user,
        ]);
    }

    public function update(Request $request, UserProfile $profile)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'work_categories' => 'nullable|array',
            'department' => 'nullable|string|max:100',
            'municipality' => 'nullable|string|max:100',
            'zone' => 'nullable|string|max:50',
            'neighborhood' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);
        //Elimina la imagen registrada
        if ($request->has('remove_profile_picture') && $profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
            $profile->profile_picture = null;
        }
        // Subir nueva imagen
        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $profile->profile_picture = $path;
        }
        // Guardar las categorías como array JSON
        $profile->work_categories = $validated['work_categories'] ?? [];

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('profile.show', $profile->user_id)
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}
