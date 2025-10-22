<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employee = User::firstOrCreate(
            ['email' => 'empleado@jobly.com'],
            [
                'first_name' => 'Mario',
                'last_name' => 'Empleado',
                'email_verified_at' => now(),
                'password' => Hash::make('Empleado123!'),
                'phone' => '22223333',
                'tos_accepted' => true,
                'tos_accepted_at' => now(),
            ]
        );

        $employee->syncRoles(['employee']);
    }
}
