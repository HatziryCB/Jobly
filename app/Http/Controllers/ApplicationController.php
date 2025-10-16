<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(\Illuminate\Http\Request $request, \App\Models\Offer $offer) {
        abort_unless(auth()->check() && auth()->user()->role==='employee', 403, 'Solo empleados pueden postular.');
        $data = $request->validate(['message'=>['nullable','string','max:1000']]);
        \App\Models\Application::firstOrCreate(
            ['offer_id'=>$offer->id,'employee_id'=>auth()->id()],
            ['message'=>$data['message'] ?? null]
        );
        return back()->with('status','Postulación enviada.');
    }

    public function accept(\App\Models\Application $application) {
        abort_unless(auth()->id() === $application->offer->employer_id, 403);
        $application->update(['status'=>'accepted','accepted_at'=>now()]);
        $application->offer->update(['status'=>'hired']);
        return back()->with('status','Postulante aceptado y oferta marcada como contratada.');
    }
}
