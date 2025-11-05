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

    public function show($id)
    {
        $verification = IdentityVerification::with('user.profile')->findOrFail($id);

        return response()->json([
            'html' => view('admin.verifications.partials._detail', compact('verification'))->render()
        ]);
    }


    public function approve($id)
    {
        $verification = IdentityVerification::findOrFail($id);

        $verification->update(['status' => 'verified']);
        $verification->user->profile?->update([
            'verification_status' => 'verified',
        ]);

        return back()->with('success', 'La solicitud fue aprobada correctamente.');
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
