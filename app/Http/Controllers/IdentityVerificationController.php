<?php

namespace App\Http\Controllers;

use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdentityVerificationController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // 🔹 Auto-expirar solicitudes pendientes de más de 5 días
        IdentityVerification::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        // 🔹 Verificar si el usuario tiene solicitud vigente
        $verification = IdentityVerification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();

        if ($verification) {
            return redirect()->route('profile.show', $user->id)
                ->with('warning', 'Ya tienes una solicitud de verificación en revisión. Espera la respuesta del administrador o que expire para volver a enviarla.');
        }

        // 🔹 Validar datos mínimos del perfil
        $missing = [];
        if (empty($user->first_name)) $missing[] = 'primer nombre';
        if (empty($user->last_name)) $missing[] = 'primer apellido';
        if (empty($profile->birth_date)) $missing[] = 'fecha de nacimiento';
        if (empty($profile->gender) || $profile->gender === 'unspecified') $missing[] = 'género';

        if (!empty($missing)) {
            $missingFields = implode(', ', $missing);
            session()->flash('warning', "Faltan datos esenciales de identidad ($missingFields).
            Completa esta información antes de solicitar la verificación.
            Sin estos datos, tu solicitud será rechazada automáticamente.");
        } elseif (empty($profile->department) || empty($profile->municipality)) {
            session()->flash('info', "Tu identidad está completa.
            Si adjuntas un comprobante de residencia, también podrás obtener la verificación de ubicación.");
        }

        return view('verification.create', compact('user', 'profile'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // 🔹 Limpiar el formato visual del DPI antes de validar
        $cleanDpi = preg_replace('/\D/', '', (string) $request->input('dpi'));
        $request->merge(['dpi' => $cleanDpi]);

        // 🔹 Validar campos
        $validated = $request->validate([
            'dpi'        => ['required', 'digits:13'], // ahora acepta sólo 13 dígitos ya limpios
            'dpi_front'  => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'selfie'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'voucher'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:6144'],
        ]);

        // 🔹 Subir archivos
        $basePath = "verifications/{$user->id}";
        $paths = [
            'dpi_front' => $request->file('dpi_front')->store($basePath, 'public'),
            'selfie'    => $request->file('selfie')->store($basePath, 'public'),
            'voucher'   => $request->hasFile('voucher')
                ? $request->file('voucher')->store($basePath, 'public')
                : null,
        ];

        // 🔹 Crear solicitud nueva
        IdentityVerification::create([
            'user_id' => $user->id,
            'dpi' => $validated['dpi'],
            'dpi_front' => $paths['dpi_front'],
            'selfie' => $paths['selfie'],
            'voucher' => $paths['voucher'],
            'status' => 'pending',
            'location_verified' => (bool) $paths['voucher'],
            'expires_at' => now()->addDays(5),
        ]);

        // 🔹 Actualizar perfil
        $profile = $user->profile ?? $user->profile()->create([
            'user_id' => $user->id,
        ]);

        $profile->update([
            'verification_status' => 'pending',
        ]);


        return redirect()
            ->route('profile.show', $user->id)
            ->with('success', 'Tu solicitud de verificación fue enviada correctamente. Si no es atendida en 5 días, vencerá automáticamente.');
    }
}
