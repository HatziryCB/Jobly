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
            'Cuidado de niños',
            'Cuidado de adultos mayores',
            'Eventos',
            'Mecánica',
            'Construcción',
            'Ayuda temporal',
            'Asistencia'
        ];

        return view('offers.create', compact('categories'));
    }


    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRole('employer'), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:30'],
            'category' => ['required', 'string', 'max:50'],
            'location_text' => ['required', 'string', 'max:120'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
            'pay_min' => ['nullable', 'integer', 'min:0'],
            'pay_max' => ['nullable', 'integer', 'min:0', 'gte:pay_min'],
            'requirements' => ['nullable', 'string', 'max:255'],
            'duration_unit' => ['required', 'in:horas,días,semanas,meses,hasta finalizar'],
            'duration_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        // Si la duración es "hasta f dejar cantidad como null
        if ($data['duration_unit'] === 'hasta finalizar') {
            $data['duration_quantity'] = null;
        }

        $data['employer_id'] = auth()->id();
        $data['status'] = 'open';

        Offer::create($data);

        return redirect()->route('employer.offers')->with('success', 'Oferta publicada con éxito.');
    }

    public function show(Offer $offer)
    {
        $offer->load('user');
        /*if (!auth()->check()) {
           return redirect()->route('login')->with('message', 'Inicia sesión para ver los detalles de la oferta.');
        }*/
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
            'Cuidado de niños',
            'Cuidado de adultos mayores',
            'Eventos',
            'Mecánica',
            'Construcción',
            'Ayuda temporal',
            'Asistencia'
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
            'duration_unit' => ['required', 'in:horas,días,semanas,meses,hasta finalizar'],
            'duration_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($data['duration_unit'] === 'hasta finalizar') {
            $data['duration_quantity'] = null;
        }

        $offer->update($data);

        return redirect()->route('offers.show', $offer)->with('status', 'Oferta actualizada.');
    }

    public function destroy(\App\Models\Offer $offer) {
        abort_unless(auth()->id() === $offer->employer_id, 403);
        $offer->delete();
        return redirect()->route('offers.index')->with('status','Oferta eliminada.');
    }

    public function myOffers(Request $request)
    {
        abort_unless(auth()->user()->hasRole('employer'), 403);

        $q = $request->input('q');
        $status = $request->input('status');
        $category = $request->input('category');

        $offers = Offer::where('employer_id', auth()->id())
            ->when($q, fn($query) =>
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            )
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($category, fn($query) => $query->where('category', $category))
            ->latest()
            ->paginate(6);

        $categories = [
            'Limpieza', 'Pintura', 'Mudanza', 'Jardinería', 'Reparaciones',
            'Electricidad', 'Plomería', 'Cuidado de niños', 'Eventos',
            'Mecánica', 'Construcción', 'Asistencia'
        ];

        return view('employer.offers', compact('offers', 'categories', 'q', 'status', 'category'));
    }

    public function candidates(Offer $offer)
    {
        abort_unless(auth()->user()->hasRole('employer') && auth()->id() === $offer->employer_id, 403);

        $applications = $offer->applications()->with(['employee.profile'])->get();

        return view('offers.candidates', compact('offer', 'applications'));
    }

}
