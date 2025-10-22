<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $employer = User::whereHas('roles', fn($q) => $q->where('name', 'employer'))->first();

        if (!$employer) {
            $employer = User::factory()->create([
                'name' => 'Empleador Demo',
                'email' => 'empleador@demo.com',
            ]);
            $employer->assignRole('employer');
        }

        Offer::factory(10)->create([
            'employer_id' => $employer->id
        ]);
    }
}
