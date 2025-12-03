<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::where('role', 'teacher')->first();

        $classes = [
            [
                'name' => 'Programação Web I',
                'code' => 'PW101',
                'description' => 'Introdução ao desenvolvimento web com HTML, CSS e JavaScript',
                'teacher_id' => $teacher->id,
                'academic_year' => '2025',
                'semester' => 1,
                'active' => true,
            ],
            [
                'name' => 'Banco de Dados',
                'code' => 'BD201',
                'description' => 'Fundamentos de modelagem e implementação de bancos de dados',
                'teacher_id' => $teacher->id,
                'academic_year' => '2025',
                'semester' => 1,
                'active' => true,
            ],
            [
                'name' => 'Algoritmos e Estruturas de Dados',
                'code' => 'AED301',
                'description' => 'Estudo de algoritmos e estruturas de dados fundamentais',
                'teacher_id' => $teacher->id,
                'academic_year' => '2025',
                'semester' => 2,
                'active' => true,
            ],
            [
                'name' => 'Engenharia de Software',
                'code' => 'ES401',
                'description' => 'Metodologias e práticas de desenvolvimento de software',
                'teacher_id' => $teacher->id,
                'academic_year' => '2024',
                'semester' => 2,
                'active' => false,
            ],
        ];

        foreach ($classes as $class) {
            ClassRoom::create($class);
        }
    }
}
