<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show dashboard with statistics.
     */
    public function index()
    {
        $user = auth()->user();

        // Contadores básicos
        $totalStudents = Student::active()->count();

        $classesQuery = ClassRoom::active();
        if ($user->isTeacher()) {
            $classesQuery->where('teacher_id', $user->id);
        }
        $totalClasses = $classesQuery->count();

        // Taxa de presença (esta semana)
        $startDate = Carbon::now()->startOfWeek();
        $attendanceQuery = Attendance::where('date', '>=', $startDate);

        if ($user->isTeacher()) {
            $attendanceQuery->whereIn('class_id', $user->classes->pluck('id'));
        }

        $totalRecords = $attendanceQuery->count();
        $presentRecords = (clone $attendanceQuery)->present()->count();

        $attendanceRate = $totalRecords > 0
            ? round(($presentRecords / $totalRecords) * 100, 1)
            : 0;

        return view('dashboard', compact(
            'totalStudents',
            'totalClasses',
            'attendanceRate'
        ));
    }
}
