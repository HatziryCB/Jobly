<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el usuario si no existe
        $admin = User::firstOrCreate(
            ['email' => 'admin@jobly.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Jobly',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin1234!'),
                'phone' => '12345678',
                'tos_accepted' => true,
                'tos_accepted_at' => now(),
            ]
        );

        // Asegura que el rol exista y lo asigna.
        $admin->syncRoles(['admin']);
    }
}
