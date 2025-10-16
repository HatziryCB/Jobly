<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index()
    {
        $q = request('q'); // search query
        $offers = \App\Models\Offer::when($q, function($query) use ($q) {
            $query->where('title','like',"%$q%")
                ->orWhere('description','like',"%$q%");
        })
            ->where('status','open')
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('offers.index', compact('offers','q'));
    }

    public function create()
    {
        abort_unless(auth()->user()?->role === 'employer', 403, 'Solo empleadores pueden publicar.');
        return view('offers.create');
    }

    public function store(\Illuminate\Http\Request $request) {
        abort_unless(auth()->user()?->role === 'employer', 403);
        $data = $request->validate([
            'title' => ['required','string','max:120'],
            'description' => ['required','string','min:10'],
            'location_text' => ['nullable','string','max:120'],
            'pay_min' => ['nullable','integer','min:0'],
            'pay_max' => ['nullable','integer','min:0','gte:pay_min'],
        ]);
        $data['employer_id'] = auth()->id();
        \App\Models\Offer::create($data);
        return redirect()->route('offers.index')->with('status','Oferta publicada.');
    }

    public function show(\App\Models\Offer $offer) {
        return view('offers.show', compact('offer'));
    }

    public function edit(\App\Models\Offer $offer) {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        return view('offers.edit', compact('offer'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Offer $offer) {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        $data = $request->validate([
            'title' => ['required','string','max:120'],
            'description' => ['required','string','min:10'],
            'location_text' => ['nullable','string','max:120'],
            'pay_min' => ['nullable','integer','min:0'],
            'pay_max' => ['nullable','integer','min:0','gte:pay_min'],
            'status' => ['required','in:draft,open,hired,closed'],
        ]);
        $offer->update($data);
        return redirect()->route('offers.show',$offer)->with('status','Oferta actualizada.');
    }

    public function destroy(\App\Models\Offer $offer) {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        $offer->delete();
        return redirect()->route('offers.index')->with('status','Oferta eliminada.');
    }
}
