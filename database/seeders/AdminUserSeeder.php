<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder {
    public function run(): void {
        User::firstOrCreate(
            ['email' => 'admin@jobly.test'],
            [
                'name' => 'Jobly Admin',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'tos_accepted' => true,
                'tos_accepted_at' => now(),
            ]
        );
    }
}
