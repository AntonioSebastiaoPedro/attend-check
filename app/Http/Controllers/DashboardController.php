<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard with statistics.
     */
    public function index()
    {
        $user = auth()->user();

        // Estatísticas gerais
        $totalStudents = Student::active()->count();
        $totalClasses = ClassRoom::active()
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->forTeacher($user->id);
            })
            ->count();

        // Presenças de hoje
        $todayDate = now()->format('Y-m-d');
        $todayAttendances = Attendance::forDate($todayDate)
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->whereHas('class', function($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->count();

        $todayPresent = Attendance::forDate($todayDate)
            ->present()
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->whereHas('class', function($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->count();

        // Últimas presenças registradas
        $recentAttendances = Attendance::with(['student', 'class', 'recordedBy'])
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->whereHas('class', function($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->latest('date')
            ->latest('time')
            ->limit(10)
            ->get();

        // Turmas do usuário
        $myClasses = ClassRoom::active()
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->forTeacher($user->id);
            })
            ->withCount('students')
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalClasses',
            'todayAttendances',
            'todayPresent',
            'recentAttendances',
            'myClasses'
        ));
    }
}
