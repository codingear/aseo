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
        User::create([
            'name' => 'Braulio Miramontes',
            'username' => 'braulio',
            'email' => 'codingear@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Crear usuario Susana Ahumada
        User::create([
            'name' => 'Susana Ahumada',
            'username' => 'susana',
            'email' => 'susanaahumadadeleon@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }
}
