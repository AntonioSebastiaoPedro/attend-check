<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@presentrack.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Professor
        User::create([
            'name' => 'Professor Demo',
            'email' => 'professor@presentrack.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);
    }
}
