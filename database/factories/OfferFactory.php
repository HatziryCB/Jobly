<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        $faker = Faker::create();

        return [
            'title' => $faker->randomElement([
                'Jardinero por día',
                'Ayudante de construcción',
                'Servicio de limpieza doméstica',
                'Pintor de interiores',
                'Cuidador temporal',
            ]),

            'description' => $faker->paragraph(),
            'requirements' => $faker->sentence(),

            'category' => $faker->randomElement(['Limpieza', 'Pintura', 'Mudanza', 'Electricidad']),

            'location_text' => $faker->address(),

            'lat' => $faker->latitude(15.69, 15.74),
            'lng' => $faker->longitude(-88.61, -88.58),

            'pay_min' => $faker->numberBetween(50, 150),
            'pay_max' => $faker->numberBetween(151, 300),

            'duration_unit' => $faker->randomElement(['horas', 'días', 'semanas', 'meses', 'hasta finalizar']),
            'duration_quantity' => function (array $attributes) {
                return $attributes['duration_unit'] === 'hasta finalizar'
                    ? null
                    : rand(1, 10);
            },

            // ✅ Ahora esto ya no rompe porque hay empleadores creados antes
            'employer_id' => User::whereHas('roles', fn($q) =>
            $q->where('name', 'employer')
            )->inRandomOrder()->value('id'),

            'status' => 'open',
        ];
    }
}
