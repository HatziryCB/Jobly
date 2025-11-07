<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ApplicationController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = auth()->user();

        // Obtener parámetros de la solicitud
        $query = $request->get('q');
        $category = $request->get('category');
        $status = $request->get('status');

        // Definir la lista de categorías
        $categories = [
            'Limpieza', 'Pintura', 'Mudanza', 'Jardinería', 'Reparaciones', 'Electricidad',
            'Plomería', 'Cuidado de niños', 'Cuidado de adultos mayores',
            'Eventos', 'Mecánica', 'Construcción', 'Ayuda temporal', 'Asistencia'
        ];

        // Inicia la consulta
        $applications = Application::with('offer')
            ->where('employee_id', $user->id);

        // Aplica filtros
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
        // Obtener los resultados paginados, manteniendo los filtros en la URL
        $applications = $applications->latest()
            ->paginate(4)
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

        abort_unless($user->hasRole('employee'), 403, 'Solo los empleados pueden postular.');

        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        // Evitar duplicados
        $alreadyApplied = Application::where('offer_id', $offer->id)
            ->where('employee_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Ya te has postulado a esta oferta.');
        }

        Application::create([
            'offer_id' => $offer->id,
            'employee_id' => $user->id,
            'message' => $data['message'] ?? null,
            'status' => 'pending', // 🔹 Lo agregamos para que quede claro
        ]);

        return redirect()->route('employee.applications')->with('success', '¡Postulación enviada exitosamente!');
    }

    public function accept(Offer $offer, User $employee)
    {
        // Solo el empleador propietario puede aceptar
        abort_unless(auth()->id() === $offer->employer_id, 403);

        $application = Application::where('offer_id', $offer->id)
            ->where('employee_id', $employee->id)
            ->firstOrFail();

        // Evitar dobles aceptaciones
        if ($offer->status === 'accepted' || $offer->status === 'hired') {
            return back()->with('info', 'Ya se ha contratado un candidato para esta oferta.');
        }

        // Actualizar estados
        $application->update(['status' => 'accepted']);
        $offer->update([
            'status' => 'hired',
            'hired_employee_id' => $employee->id,
        ]);

        // Rechazar los demás
        Application::where('offer_id', $offer->id)
            ->where('id', '!=', $application->id)
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Has aceptado al candidato. Esperando confirmación del empleado.');
    }

    public function reject(Offer $offer, User $employee)
    {
        // Solo el empleador propietario puede rechazar
        abort_unless(auth()->id() === $offer->employer_id, 403);

        $application = Application::where('offer_id', $offer->id)
            ->where('employee_id', $employee->id)
            ->firstOrFail();

        $application->update(['status' => 'rejected']);

        return back()->with('success', 'Candidato rechazado.');
    }
    
    public function cancel(Application $application)
    {
        abort_unless(auth()->id() === $application->employee_id, 403);

        if (in_array($application->status, ['accepted', 'rejected'])) {
            return back()->with('error', 'No puedes cancelar una postulación ya procesada.');
        }

        $application->delete();

        return back()->with('success', 'Tu postulación fue cancelada exitosamente.');
    }

}
