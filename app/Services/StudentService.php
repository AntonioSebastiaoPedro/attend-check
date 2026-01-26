<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    /**
     * Retorna estudantes com filtros.
     */
    public function getStudents(array $filters = []): LengthAwarePaginator
    {
        $query = Student::query();

        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        if (isset($filters['active'])) {
            if ($filters['active'] == '1') {
                $query->active();
            } else {
                $query->where('active', false);
            }
        }

        return $query->orderBy('name')->paginate(15);
    }

    /**
     * Cria um novo estudante.
     */
    public function createStudent(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Atualiza um estudante.
     */
    public function updateStudent(Student $student, array $data): bool
    {
        return $student->update($data);
    }

    /**
     * Remove um estudante.
     */
    public function deleteStudent(Student $student): bool
    {
        return $student->delete();
    }

    /**
     * Carrega detalhes do estudante para exibição.
     */
    public function loadStudentDetails(Student $student): Student
    {
        return $student->load(['classes', 'attendances' => function($query) {
            $query->latest()->limit(20);
        }]);
    }
}
