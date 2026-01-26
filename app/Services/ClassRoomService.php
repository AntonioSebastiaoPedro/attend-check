<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClassRoomService
{
    /**
     * Get classes with filters.
     */
    public function getClasses(array $filters = []): LengthAwarePaginator
    {
        $query = ClassRoom::with('teacher');

        if (isset($filters['active'])) {
            if ($filters['active'] == '1') {
                $query->active();
            } else {
                $query->where('active', false);
            }
        }

        if (isset($filters['auth_user'])) {
            $user = $filters['auth_user'];
            if ($user->isTeacher()) {
                $query->forTeacher($user->id);
            } elseif (isset($filters['teacher_id'])) {
                $query->forTeacher($filters['teacher_id']);
            }
        }

        return $query->orderBy('name')->paginate(15);
    }

    /**
     * Create a new class.
     */
    public function createClass(array $data): ClassRoom
    {
        return ClassRoom::create($data);
    }

    /**
     * Update a class.
     */
    public function updateClass(ClassRoom $class, array $data): bool
    {
        return $class->update($data);
    }

    /**
     * Delete a class.
     */
    public function deleteClass(ClassRoom $class): bool
    {
        return $class->delete();
    }

    /**
     * Load class details for show.
     */
    public function loadClassDetails(ClassRoom $class): ClassRoom
    {
        return $class->load(['teacher', 'students', 'attendances' => function($query) {
            $query->latest()->limit(50);
        }]);
    }

    /**
     * Get available students for a class.
     */
    public function getAvailableStudents(ClassRoom $class): Collection
    {
        return Student::active()
            ->whereNotIn('id', $class->students->pluck('id'))
            ->orderBy('name')
            ->get();
    }

    /**
     * Attach students to a class.
     */
    public function attachStudents(ClassRoom $class, array $studentIds): void
    {
        $class->students()->attach($studentIds);
    }

    /**
     * Detach a student from a class.
     */
    public function detachStudent(ClassRoom $class, int $studentId): void
    {
        $class->students()->detach($studentId);
    }
}
