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
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'location_text' => 'Puerto Barrios, Izabal',
            'lat' => 15.7196,
            'lng' => -88.5941,
            'pay_min' => $this->faker->numberBetween(100, 300),
            'pay_max' => $this->faker->numberBetween(301, 600),
            'category' => $this->faker->randomElement([
                'Limpieza', 'Pintura', 'Mudanza',
                'Jardinería', 'Reparaciones', 'Electricidad', 'Plomería'
            ]),
            'status' => 'open',
        ];
    }
}
