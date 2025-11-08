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
        return [
            'title' => $this->faker->randomElement([
                'Jardinero por día',
                'Ayudante de construcción',
                'Servicio de limpieza doméstica',
                'Pintor de interiores',
                'Cuidador temporal',
            ]),
            'description' => $this->fake->paragraph,
            'requirements' => $this->fake->sentence,
            'category' => $this->fake->randomElement(['Limpieza', 'Pintura', 'Mudanza', 'Electricidad']),
            'location_text' => $this->fake->address,
            'lat' => $this->fake->latitude(15.69, 15.74), // Puerto Barrios approx
            'lng' => $this->fake->longitude(-88.61, -88.58),
            'pay_min' => $this->fake->numberBetween(50, 150),
            'pay_max' => $this->fake->numberBetween(151, 300),
            'duration_unit' => $this->fake->randomElement(['horas', 'días', 'semanas', 'meses', 'hasta finalizar']),
            'duration_quantity' => function (array $attributes) {
                return $attributes['duration_unit'] === 'hasta finalizar'
                    ? null
                    : rand(1, 10);
            },
            'employer_id' => fn() => User::whereHas('roles', fn($q) =>
            $q->where('name', 'employer')
            )->inRandomOrder()->value('id'),

            'status' => 'open',
        ];

    }
}
