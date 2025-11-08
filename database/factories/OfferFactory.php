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
            'title' => fake()->randomElement([
                'Jardinero por día',
                'Ayudante de construcción',
                'Servicio de limpieza doméstica',
                'Pintor de interiores',
                'Cuidador temporal',
            ]),

            'description' => fake()->paragraph(),
            'requirements' => fake()->sentence(),

            'category' => fake()->randomElement(['Limpieza', 'Pintura', 'Mudanza', 'Electricidad']),

            'location_text' => fake()->address(),

            'lat' => fake()->latitude(15.69, 15.74),
            'lng' => fake()->longitude(-88.61, -88.58),

            'pay_min' => fake()->numberBetween(50, 150),
            'pay_max' => fake()->numberBetween(151, 300),

            'duration_unit' => fake()->randomElement(['horas', 'días', 'semanas', 'meses', 'hasta finalizar']),
            'duration_quantity' => function (array $attributes) {
                return $attributes['duration_unit'] === 'hasta finalizar'
                    ? null
                    : rand(1, 10);
            },

            // Usar empleadores ya seedados
            'employer_id' => User::whereHas('roles', fn($q) =>
            $q->where('name', 'employer')
            )->inRandomOrder()->value('id'),

            'status' => 'open',
        ];
    }
}
