<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        $pick = function (array $arr) { return $arr[array_rand($arr)]; };
        $randFloat = function (float $min, float $max) {
            return $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
        };

        $titles = [
            'Jardinero por día',
            'Ayudante de construcción',
            'Servicio de limpieza doméstica',
            'Pintor de interiores',
            'Cuidador temporal',
        ];

        $requirements = [
            'Disponibilidad inmediata y puntualidad.',
            'Experiencia mínima de 6 meses.',
            'Herramientas básicas propias.',
            'Trabajo en equipo y comunicación.',
            'Buena condición física.',
        ];

        $categories = ['Limpieza', 'Pintura', 'Mudanza', 'Electricidad'];

        $streets = ['7a Avenida', '5a Calle', 'Barrio El Centro', 'Santa Isabel', 'La Coroza', 'Santo Tomás de Castilla'];
        $locationText = $pick($streets) . ', Puerto Barrios, Izabal';

        // Debe existir al menos 1 employer por tus seeders EmployerSeeder
        $employerId = User::whereHas('roles', fn($q) => $q->where('name', 'employer'))
            ->inRandomOrder()
            ->value('id');

        if (!$employerId) {

            return [
                'title' => $pick($titles),
                'description' => 'Descripción pendiente.',
                'requirements' => $pick($requirements),
                'category' => $pick($categories),
                'location_text' => $locationText,
                'lat' => $randFloat(15.69, 15.74),
                'lng' => $randFloat(-88.61, -88.58),
                'pay_min' => 80,
                'pay_max' => 160,
                'duration_unit' => 'horas',
                'duration_quantity' => 4,
                'employer_id' => null,
                'status' => 'open',
            ];
        }

        $durationUnits = ['horas', 'días', 'semanas', 'meses', 'hasta finalizar'];
        $du = $pick($durationUnits);
        $dq = $du === 'hasta finalizar' ? null : random_int(1, 10);

        $payMin = random_int(50, 150);
        $payMax = random_int(max($payMin + 1, 151), 300);

        return [
            'title' => $pick($titles),
            'description' => 'Trabajo temporal en zona de Puerto Barrios. Se valora responsabilidad y buena actitud.',
            'requirements' => $pick($requirements),
            'category' => $pick($categories),
            'location_text' => $locationText,
            'lat' => $randFloat(15.69, 15.74),
            'lng' => $randFloat(-88.61, -88.58),
            'pay_min' => $payMin,
            'pay_max' => $payMax,
            'duration_unit' => $du,
            'duration_quantity' => $dq,
            'employer_id' => $employerId,
            'status' => 'open',
        ];
    }
}
