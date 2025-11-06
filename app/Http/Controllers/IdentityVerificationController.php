<?php

namespace App\Http\Controllers;

use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdentityVerificationController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Auto-expirar solicitudes pendientes de más de 5 días
        IdentityVerification::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        // Verificar si el usuario tiene solicitud vigente
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

        // Validar datos mínimos del perfil
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

        // Normalizar DPI
        $cleanDpi = preg_replace('/\D/', '', $request->input('dpi'));
        $request->merge(['dpi' => $cleanDpi]);

        // Validación
        $validated = $request->validate([
            'dpi'        => ['required', 'digits:13'],
            'dpi_front'  => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'selfie'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'voucher'    => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:6144'],
        ]);

        // Estado actual
        $status = $user->profile->verification_status ?? 'none';

        // 1) Si ya tiene full verified → no puede pedir más verificaciones
        if ($status === 'full_verified') {
            return back()->withErrors([
                'dpi' => 'Ya cuentas con verificación completa. No es necesario enviar otra solicitud.'
            ]);
        }

        // 2) Bloquear si ya tiene solicitud pendiente
        $pending = IdentityVerification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($pending) {
            return back()->withErrors([
                'dpi' => 'Ya tienes una solicitud en revisión. Espera la respuesta.'
            ]);
        }

        // 3) Si el DPI pertenece a otro usuario verificado → prohibido
        $dpiLocked = IdentityVerification::where('dpi', $cleanDpi)
            ->where('status', 'approved')
            ->where('user_id', '!=', $user->id)
            ->exists();

        if ($dpiLocked) {
            return back()->withErrors([
                'dpi' => 'Este DPI ya pertenece a otro usuario verificado.'
            ]);
        }

        // 4) Si el usuario ya tiene identidad verificada, no puede cambiar el DPI
        $priorApproved = IdentityVerification::where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        if ($priorApproved && $priorApproved->dpi !== $cleanDpi) {
            return back()->withErrors([
                'dpi' => 'No puedes cambiar tu DPI después de ser verificado. Si hubo error, contacta soporte.'
            ]);
        }

        // 5) Si está en "verified" pero NO subió voucher → no puede solicitar full
        if ($status === 'verified' && !$request->hasFile('voucher')) {
            return back()->withErrors([
                'voucher' => 'Para completar la verificación debes adjuntar comprobante de domicilio.'
            ]);
        }

        // Guardar archivos
        $basePath = "verifications/{$user->id}";
        $paths = [
            'dpi_front' => $request->file('dpi_front')->store($basePath, 'public'),
            'selfie'    => $request->file('selfie')->store($basePath, 'public'),
            'voucher'   => $request->hasFile('voucher')
                ? $request->file('voucher')->store($basePath, 'public')
                : null,
        ];

        // Registrar solicitud
        IdentityVerification::create([
            'user_id' => $user->id,
            'dpi' => $cleanDpi,
            'dpi_front' => $paths['dpi_front'],
            'selfie' => $paths['selfie'],
            'voucher' => $paths['voucher'],
            'status' => 'pending',
            'location_verified' => (bool)$paths['voucher'],
            'expires_at' => now()->addDays(5),
        ]);

        // Poner perfil en estado pendiente
        $user->profile->update(['verification_status' => 'pending']);

        return redirect()
            ->route('profile.show', $user->id)
            ->with('success', 'Tu solicitud fue enviada correctamente. Recibirás respuesta dentro de 5 días.');
    }

}
