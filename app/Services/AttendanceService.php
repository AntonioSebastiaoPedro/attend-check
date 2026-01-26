<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Retorna as presenças com filtros.
     */
    public function getAttendances(array $filters = []): LengthAwarePaginator
    {
        $query = Attendance::with(['student', 'class', 'recordedBy']);

        if (isset($filters['user'])) {
            $user = $filters['user'];
            if ($user->isTeacher()) {
                $query->whereIn('class_id', $user->classes->pluck('id'));
            }
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('class_id', $filters['class_id']);
        }

        if (isset($filters['student_search']) && $filters['student_search']) {
            $search = $filters['student_search'];
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('registration_number', 'ilike', "%{$search}%");
            });
        }

        if (isset($filters['date']) && $filters['date']) {
            $query->where('date', $filters['date']);
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            $query->where('date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->where('date', '<=', $filters['end_date']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        return $query->latest('date')->latest('time')->paginate($filters['per_page'] ?? 30)->withQueryString();
    }

    /**
     * Armazena os registros de presença.
     *
     * @throws \Exception
     */
    public function storeAttendances(array $data, int $recordedById): void
    {
        DB::beginTransaction();
        try {
            foreach ($data['attendances'] as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $attendanceData['student_id'],
                        'class_id' => $data['class_id'],
                        'date' => $data['date'],
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'time' => now()->format('H:i:s'),
                        'notes' => $attendanceData['notes'] ?? null,
                        'recorded_by' => $recordedById,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Retorna estatísticas de presença de um estudante.
     */
    public function getStudentStats(Student $student): array
    {
        $totalAttendances = $student->attendances()->count();
        $totalPresent = $student->attendances()->present()->count();
        $totalAbsent = $student->attendances()->absent()->count();
        $attendanceRate = $totalAttendances > 0
            ? round(($totalPresent / $totalAttendances) * 100, 2)
            : 0;

        return [
            'total' => $totalAttendances,
            'present' => $totalPresent,
            'absent' => $totalAbsent,
            'rate' => $attendanceRate,
        ];
    }

    /**
     * Retorna os dados do relatório de uma turma.
     */
    public function getClassReportData(ClassRoom $class, string $startDate, string $endDate): Collection
    {
        $students = $class->students()->with(['attendances' => function($query) use ($class, $startDate, $endDate) {
            $query->forClass($class->id)
                ->whereBetween('date', [$startDate, $endDate]);
        }])->get();

        return $students->map(function($student) {
            $total = $student->attendances->count();
            $present = $student->attendances->where('status', 'present')->count();
            $absent = $student->attendances->where('status', 'absent')->count();
            $rate = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            return [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'rate' => $rate,
            ];
        });
    }

    /**
     * Retorna os dados para exportação.
     */
    public function getExportData(array $filters = []): Collection
    {
        $query = Attendance::with(['student', 'class', 'recordedBy']);

        if (isset($filters['user'])) {
            $user = $filters['user'];
            if ($user->isTeacher()) {
                $query->whereIn('class_id', $user->classes->pluck('id'));
            }
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('class_id', $filters['class_id']);
        }

        if (isset($filters['student_search']) && $filters['student_search']) {
            $search = $filters['student_search'];
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('registration_number', 'ilike', "%{$search}%");
            });
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            $query->where('date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->where('date', '<=', $filters['end_date']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        return $query->latest('date')->get();
    }
}
