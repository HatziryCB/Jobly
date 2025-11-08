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
            'description' => $this->faker->paragraph,
            'requirements' => $this->faker->sentence,
            'category' => $this->faker->randomElement(['Limpieza', 'Pintura', 'Mudanza', 'Electricidad']),
            'location_text' => $this->faker->address,
            'lat' => $this->faker->latitude(15.69, 15.74), // Puerto Barrios approx
            'lng' => $this->faker->longitude(-88.61, -88.58),
            'pay_min' => $this->faker->numberBetween(50, 150),
            'pay_max' => $this->faker->numberBetween(151, 300),
            'duration_unit' => $this->faker->randomElement(['horas', 'días', 'semanas', 'meses', 'hasta finalizar']),
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
