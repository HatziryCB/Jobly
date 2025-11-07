<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentityVerification;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = IdentityVerification::with('user.profile');

        // 🔍 Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            if ($request->type === 'identity') {
                $query->whereNull('voucher');
            } elseif ($request->type === 'full') {
                $query->whereNotNull('voucher');
            }
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Orden por fecha
        $order = $request->input('order', 'desc');
        $query->orderBy('created_at', $order);

        $verifications = $query->paginate(10)->appends($request->query());

        // Contadores para dashboard mini
        $stats = [
            'pending' => IdentityVerification::where('status', 'pending')->count(),
            'verified' => IdentityVerification::where('status', 'verified')->count(),
            'rejected' => IdentityVerification::where('status', 'rejected')->count(),
        ];

        return view('admin.verifications.index', compact('verifications', 'stats'));
    }

    public function dashboard()
    {
        $stats = $this->getVerificationStats();

        return view('admin.dashboard', [
            'pendingCount' => $stats['pending'],
            'verifiedCount' => $stats['verified'],
            //'locationVerifiedCount' => $stats['locationVerified'],
        ]);
    }

    private function getVerificationStats()
    {
        return [
            'pending' => IdentityVerification::where('status', 'pending')->count(),
            'verified' => IdentityVerification::where('status', 'verified')->count(),
            //'locationVerified' => IdentityVerification::whereNotNull('location_verified_at')->count(),
        ];
    }
    public function show($id)
    {
        $verification = IdentityVerification::with('user.profile')->findOrFail($id);
        return view('admin.verifications.partials._detail', compact('verification'));
    }

    public function approve($id)
    {
        $verification = IdentityVerification::with('user.profile')->findOrFail($id);

        // Marcar la solicitud como aprobada
        $verification->update(['status' => 'approved']);

        // Obtener usuario y perfil
        $user = $verification->user;
        $profile = $user->profile;

        // 🔹 Si la solicitud incluye comprobante de domicilio → verificación completa
        if ($verification->voucher) {
            $profile->verification_status = 'full_verified';
        } else {
            $profile->verification_status = 'verified';
        }

        $profile->save();

        // 🔹 Expirar otras solicitudes pendientes del mismo usuario
        IdentityVerification::where('user_id', $user->id)
            ->where('id', '!=', $verification->id)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);

        return response()->json(['success' => true]);
    }


    public function reject(Request $request, $id)
    {
        $verification = IdentityVerification::with('user.profile')->findOrFail($id);

        // Marcar como rechazada
        $verification->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason')
        ]);

        $profile = $verification->user->profile;

        // Actualizar estado del perfil
        $profile->update(['verification_status' => 'rejected']);

        // Expirar otras solicitudes pendientes
        IdentityVerification::where('user_id', $verification->user_id)
            ->where('id', '!=', $verification->id)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }

    public function history(Request $request)
    {
        $verifications = IdentityVerification::with('user')
            ->whereIn('status', ['approved', 'rejected', 'expired'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) =>
            $q->whereHas('user', fn($u) =>
            $u->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
            )
            )
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.verifications.history', compact('verifications'));
    }
    public function userHistory($userId)
    {
        $verifications = IdentityVerification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $user = User::findOrFail($userId);

        return view('admin.verifications.user-history', compact('verifications', 'user'));
    }

}
