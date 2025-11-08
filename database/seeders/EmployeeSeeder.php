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
        $employees = [
            [
                'first_name' => 'Mario',
                'last_name' => 'Empleado',
                'email' => 'empleado@jobly.com',
                'phone' => '22223333',
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Ramírez',
                'email' => 'empleado2@jobly.com',
                'phone' => '55556666',
            ],
            [
                'first_name' => 'Luis',
                'last_name' => 'Gómez',
                'email' => 'empleado3@jobly.com',
                'phone' => '77778888',
            ],
        ];

        foreach ($employees as $data) {
            $employee = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('Empleado123!'),
                    'phone' => $data['phone'],
                    'tos_accepted' => true,
                    'tos_accepted_at' => now(),
                ]
            );

            $employee->syncRoles(['employee']);
        }
    }

}
