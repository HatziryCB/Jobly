<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployerSeeder extends Seeder
{
    public function run(): void
    {
        $employer = User::firstOrCreate(
            ['email' => 'empleador@jobly.com'],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Empleador',
                'email_verified_at' => now(),
                'password' => Hash::make('Empleador123!'),
                'phone' => '11112222',
                'tos_accepted' => true,
                'tos_accepted_at' => now(),
            ]
        );

        $employer->syncRoles(['employer']);
    }
}
