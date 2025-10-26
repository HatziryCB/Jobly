<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        $q = $request->input('q');
        $category = $request->input('category');

        $offersQuery = Offer::query()
            ->where('status', 'open')
            ->when($q, fn($query) =>
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            )
            ->when($category, fn($query) =>
            $query->where('category', $category)
            )
            ->latest();
        $offers = $offersQuery->paginate(10);

        $offersForMap = $offersQuery
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get(['id', 'title', 'lat', 'lng', 'location_text']);

        return view('offers.index', compact('offers', 'offersForMap', 'q', 'category'));
    }


    public function create()
    {
        abort_unless(auth()->user()->hasRole('employer'), 403);

        $categories = [
            'Limpieza',
            'Pintura',
            'Mudanza',
            'Jardinería',
            'Reparaciones',
            'Electricidad',
            'Plomería',
            'Otros'
        ];

        return view('offers.create', compact('categories'));
    }


    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRole('employer'), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10'],
            'category' => ['required', 'string', 'max:50'],
            'location_text' => ['required', 'string', 'max:120'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
            'pay_min' => ['nullable', 'integer', 'min:0'],
            'pay_max' => ['nullable', 'integer', 'min:0', 'gte:pay_min'],
            'requirements' => ['nullable', 'string', 'max:255'],
            'estimated_duration_unit' => ['required', 'in:horas,días,semanas,meses,hasta finalizar'],
            'estimated_duration_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        // Si la duración es "hasta finalizar", dejar cantidad como null
        if ($data['estimated_duration_unit'] === 'hasta finalizar') {
            $data['estimated_duration_quantity'] = null;
        }

        $data['employer_id'] = auth()->id();
        $data['status'] = 'open';

        Offer::create($data);

        return redirect()->route('offers.index')->with('status', 'Oferta publicada con éxito.');
    }

    public function show(Offer $offer) {
        return view('offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        $categories = [
            'Limpieza',
            'Pintura',
            'Mudanza',
            'Jardinería',
            'Reparaciones',
            'Electricidad',
            'Plomería',
            'Otros'
        ];
        return view('offers.edit', compact('offer', 'categories'));
    }


    public function update(Request $request, Offer $offer)
    {
        abort_unless(auth()->id() === $offer->employer_id, 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10'],
            'location_text' => ['required', 'string', 'max:120'],
            'pay_min' => ['nullable', 'integer', 'min:0'],
            'pay_max' => ['nullable', 'integer', 'min:0', 'gte:pay_min'],
            'status' => ['required', 'in:draft,open,hired,closed'],
            'requirements' => ['nullable', 'string', 'max:255'],
            'estimated_duration_unit' => ['required', 'in:horas,días,semanas,meses,hasta finalizar'],
            'estimated_duration_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($data['estimated_duration_unit'] === 'hasta finalizar') {
            $data['estimated_duration_quantity'] = null;
        }

        $offer->update($data);

        return redirect()->route('offers.show', $offer)->with('status', 'Oferta actualizada.');
    }


    public function destroy(\App\Models\Offer $offer) {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        $offer->delete();
        return redirect()->route('offers.index')->with('status','Oferta eliminada.');
    }
}
