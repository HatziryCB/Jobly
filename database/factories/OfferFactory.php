<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'requirements' => $this->faker->sentence,
            'category' => $this->faker->randomElement(['Limpieza', 'Pintura', 'Mudanza', 'Electricidad']),
            'location_text' => $this->faker->address,
            'lat' => $this->faker->latitude(15.69, 15.74), // Puerto Barrios approx
            'lng' => $this->faker->longitude(-88.61, -88.58),
            'pay_min' => $this->faker->numberBetween(50, 150),
            'pay_max' => $this->faker->numberBetween(151, 300),
            'estimated_duration_unit' => $this->faker->randomElement(['horas', 'días', 'semanas', 'hasta finalizar']),
            'estimated_duration_quantity' => function (array $attributes) {
                return $attributes['estimated_duration_unit'] === 'hasta finalizar' ? null : rand(1, 10);
            },
            'employer_id' => \App\Models\User::factory(),
            'status' => 'open',
        ];

    }
}
