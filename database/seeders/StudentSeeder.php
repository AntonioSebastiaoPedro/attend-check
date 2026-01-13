<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        dump('Iniciando StudentSeeder');
        $students = [
            ['name' => 'Ana Silva', 'registration_number' => '2025001', 'email' => 'ana@example.com'],
            ['name' => 'Bruno Oliveira', 'registration_number' => '2025002', 'email' => 'bruno@example.com'],
            ['name' => 'Carla Santos', 'registration_number' => '2025003', 'email' => 'carla@example.com'],
            ['name' => 'Diego Pereira', 'registration_number' => '2025004', 'email' => 'diego@example.com'],
            ['name' => 'Elena Costa', 'registration_number' => '2025005', 'email' => 'elena@example.com'],
            ['name' => 'Fabio Rodrigues', 'registration_number' => '2025006', 'email' => 'fabio@example.com'],
            ['name' => 'Gisele Almeida', 'registration_number' => '2025007', 'email' => 'gisele@example.com'],
            ['name' => 'Hugo Ferreira', 'registration_number' => '2025008', 'email' => 'hugo@example.com'],
            ['name' => 'Isabela Lima', 'registration_number' => '2025009', 'email' => 'isabela@example.com'],
            ['name' => 'João Souza', 'registration_number' => '2025010', 'email' => 'joao@example.com'],
        ];

        foreach ($students as $studentData) {
            $student = Student::create($studentData);

            // Vincular a todas as turmas ativas para teste
            $classes = ClassRoom::all();
            $student->classes()->attach($classes);
        }
    }
}
