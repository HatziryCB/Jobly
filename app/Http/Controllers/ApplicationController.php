<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // 1. Obtener parámetros de la solicitud
        $query = $request->get('q');
        $category = $request->get('category');
        $status = $request->get('status');

        // 2. Definir la lista de categorías
        $categories = [
            'Limpieza', 'Pintura', 'Mudanza', 'Jardinería', 'Reparaciones', 'Electricidad',
            'Plomería', 'Cuidado de niños', 'Cuidado de adultos mayores',
            'Eventos', 'Mecánica', 'Construcción', 'Ayuda temporal', 'Asistencia'
        ];

        // 3. Iniciar la consulta
        $applications = Application::with('offer')
            ->where('employee_id', $user->id);

        // 4. Aplicar filtros
        if ($query) {
            $applications->whereHas('offer', function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        if ($category) {
            $applications->whereHas('offer', function ($q) use ($category) {
                $q->where('category', $category);
            });
        }

        if ($status) {
            $applications->where('status', $status);
        }

        // 5. Obtener los resultados paginados, manteniendo los filtros en la URL
        $applications = $applications->latest()
            ->paginate(2)
            ->withQueryString();


        return view('employee.applications', [
            'applications' => $applications,
            'q'            => $query,
            'category'     => $category,
            'status'       => $status,
            'categories'   => $categories,
        ]);
    }
    public function store(Request $request, Offer $offer)
    {
        $user = auth()->user();

        // Verifica que solo empleados puedan postular
        if (!$user->hasRole('employee')) {
            abort(403, 'Solo los empleados pueden postular a ofertas.');
        }
        // Validación (mensaje opcional)
        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        // Verifica si ya se postuló
        $alreadyApplied = Application::where('offer_id', $offer->id)
            ->where('employee_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Ya te has postulado a esta oferta.');
        }
        // Crea la postulación
        Application::create([
            'offer_id' => $offer->id,
            'employee_id' => $user->id,
            'message' => $data['message'] ?? null,
        ]);
        return redirect()->route('employee.applications')->with('success', '¡Postulación enviada exitosamente!');
    }

    public function accept(Application $application)
    {
        //$this->authorize('update', $application->offer);
        $application->status = 'accepted';
        $application->save();
        // Cambia estado de la oferta a "hired"
        $application->offer->update(['status' => 'hired']);
        return redirect()->back()->with('success', 'Candidato aceptado y oferta marcada como contratada.');
    }

}
