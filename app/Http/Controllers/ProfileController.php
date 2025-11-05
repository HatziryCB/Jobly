<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->loadMissing('profile');

        if (!$user->profile) {
            $user->profile()->create([
                'verification_status' => 'none',
                'work_categories' => [],
                'average_rating' => 0.0,
            ]);
            $user->refresh();
        }

        return view('profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        $profile = $user->profile ?? $user->profile()->create();
        $categories = [
            'Limpieza', 'Pintura', 'Mudanza', 'Jardinería', 'Reparaciones',
            'Electricidad', 'Plomería', 'Cuidado de niños', 'Cuidado de adultos mayores',
            'Eventos', 'Mecánica', 'Construcción', 'Ayuda temporal', 'Asistencia'
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
            'gender' => 'nullable|in:male,female,other,unspecified',
        ]);

        $user = auth()->user();

        // Proteger edición de datos sensibles si está verificado
        if ($user->profile->isVerified()) {
            if ($request->hasAny(['first_name', 'last_name', 'birth_date', 'gender'])) {
                return back()->withErrors([
                    'error' => 'No puedes modificar datos verificados. Solicita una nueva verificación para hacerlo.'
                ]);
            }
        }

        // Actualizar contraseña si fue enviada
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', Password::min(8)
                    ->mixedCase()->letters()->numbers()->symbols()],
            ]);

            $user->update(['password' => Hash::make($request->new_password)]);

            return redirect()->route('profile.show', $profile->user_id)
                ->with('success', 'Tu contraseña ha sido actualizada correctamente.');
        }

        //  Manejo de imagen
        if ($request->has('remove_profile_picture') && $profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
            $profile->profile_picture = null;
        }

        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $profile->profile_picture = $path;
        }

        // Actualizar categorías (ya casteado)
        $profile->work_categories = $validated['work_categories'] ?? [];

        // Guardar cambios
        $profile->fill($validated);
        $profile->save();

        return redirect()->route('profile.show', $profile->user_id)
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}
