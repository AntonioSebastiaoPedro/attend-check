<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    /**
     * Get students with filters.
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
     * Create a new student.
     */
    public function createStudent(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Update a student.
     */
    public function updateStudent(Student $student, array $data): bool
    {
        return $student->update($data);
    }

    /**
     * Delete a student.
     */
    public function deleteStudent(Student $student): bool
    {
        return $student->delete();
    }

    /**
     * Load student details for show.
     */
    public function loadStudentDetails(Student $student): Student
    {
        return $student->load(['classes', 'attendances' => function($query) {
            $query->latest()->limit(20);
        }]);
    }
}
