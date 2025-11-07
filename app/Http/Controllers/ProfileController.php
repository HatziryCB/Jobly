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
    {   //abort_unless(auth()->user()->hasRole('employee'), 403);
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

        $lock = $profile->lockLevel();

        return view('profile.edit', [
            'profile' => $profile,
            'categories' => $categories,
            'user' => $user,
            'canEditIdentity' => $lock < 1,   // Si lock >=1 → identidad bloqueada
            'canEditLocation' => $lock < 2,   // Si lock >=2 → residencia bloqueada
        ]);

    }

    public function update(Request $request, UserProfile $profile)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'work_categories' => 'nullable|array',
            'department' => 'required|string|max:100',
            'municipality' => 'required|string|max:100',
            'zone' => 'nullable|string|max:50',
            'neighborhood' => 'nullable|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',

            // Campos de User
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $profile = $user->profile;
        $lock = $profile->lockLevel();

        // Bloqueo por verificación
        if ($lock >= 1) {
            $request->merge([
                'birth_date' => $profile->birth_date,
                'gender' => $profile->gender,
            ]);
        }

        if ($lock >= 2) {
            $request->merge([
                'department' => $profile->department,
                'municipality' => $profile->municipality,
            ]);
        }

        // Actualizar contraseña
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

        // Eliminar foto actual si se pidió
        if ($request->has('remove_profile_picture') && $profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
            $profile->profile_picture = null;
        }

        // Subir nueva foto
        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $profile->profile_picture = $path;
        }

        // Actualizar campos del usuario
        $user->first_name = $validated['first_name'];
        $user->second_name = $validated['second_name'] ?? null;
        $user->last_name = $validated['last_name'];
        $user->second_last_name = $validated['second_last_name'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        // Actualizar perfil
        $profile->work_categories = $validated['work_categories'] ?? [];
        $profile->fill($validated);
        $profile->save();

        return redirect()->route('profile.show', $profile->user_id)
            ->with('success', 'Perfil actualizado exitosamente.');
    }

}
