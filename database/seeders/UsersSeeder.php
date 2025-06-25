<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario Braulio Miramontes
        User::updateOrCreate(
            ['email' => 'codingear@gmail.com'],
            [
                'name' => 'Braulio Miramontes',
                'username' => 'braulio',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        // Crear usuario Susana Ahumada
        User::updateOrCreate(
            ['email' => 'susanaahumadadeleon@gmail.com'],
            [
                'name' => 'Susana Ahumada',
                'username' => 'susana',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
    }
}
