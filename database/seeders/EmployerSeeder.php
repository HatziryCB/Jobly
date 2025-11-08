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
        $employers = [
            [
                'first_name' => 'Carlos',
                'last_name' => 'Empleador',
                'email' => 'empleador@jobly.com',
                'phone' => '11112222',
            ],
            [
                'first_name' => 'Marta',
                'last_name' => 'Construcción',
                'email' => 'empleador2@jobly.com',
                'phone' => '33334444',
            ],
        ];

        foreach ($employers as $data) {
            $employer = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('Empleador123!'),
                    'phone' => $data['phone'],
                    'tos_accepted' => true,
                    'tos_accepted_at' => now(),
                ]
            );

            $employer->syncRoles(['employer']);
        }
    }

}
