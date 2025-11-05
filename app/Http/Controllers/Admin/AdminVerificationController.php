<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentityVerification;
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

        return response()->json([
            'html' => view('admin.verifications.partials._detail', compact('verification'))->render()
        ]);
    }

    public function approve($id, Request $request)
    {
        $verification = IdentityVerification::with('user.profile')->findOrFail($id);

        // Guardar los radios
        $verification->checks = $request->all();

        // Determinar insignia final
        $hasIdentity = $request->dpi_ok === 'yes'
            && $request->name_ok === 'yes'
            && $request->birth_ok === 'yes'
            && $request->gender_ok === 'yes'
            && $request->photo_ok === 'yes';

        $hasLocation = $request->location_ok === 'yes';

        if ($hasIdentity && $hasLocation) {
            $verification->user->profile->verification_badge = 'full';   // 🟣
        } elseif ($hasIdentity) {
            $verification->user->profile->verification_badge = 'identity'; // 🟦
        }

        $verification->user->profile->save();
        $verification->update(['status' => 'verified']);

        return redirect()->back()->with('success', 'Verificación aprobada');
    }


    public function reject(Request $request, IdentityVerification $verification)
    {
        $verification->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        $verification->user->profile->update(['verification_status' => 'rejected']);

        return back()->with('success', 'Solicitud rechazada.');
    }
}
