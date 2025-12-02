<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance list with filters.
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'class', 'recordedBy']);

        // Filtro por turma
        if ($request->has('class_id')) {
            $query->forClass($request->class_id);
        }

        // Filtro por estudante
        if ($request->has('student_id')) {
            $query->forStudent($request->student_id);
        }

        // Filtro por data (RF04)
        if ($request->has('date')) {
            $query->forDate($request->date);
        }

        // Filtro por período
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filtro por status
        if ($request->has('status')) {
            if ($request->status == 'present') {
                $query->present();
            } elseif ($request->status == 'absent') {
                $query->absent();
            }
        }

        $attendances = $query->latest('date')->latest('time')->paginate(30);

        // Dados para filtros
        $classes = ClassRoom::active()->orderBy('name')->get();
        $students = Student::active()->orderBy('name')->get();

        return view('attendances.index', compact('attendances', 'classes', 'students'));
    }

    /**
     * Show form to mark attendance for a class (RF03).
     */
    public function markAttendance(Request $request)
    {
        $classId = $request->get('class_id');
        $date = $request->get('date', now()->format('Y-m-d'));

        $classes = ClassRoom::active()
            ->when(auth()->user()->isTeacher(), function($q) {
                $q->forTeacher(auth()->id());
            })
            ->orderBy('name')
            ->get();

        $students = [];
        $existingAttendances = [];

        if ($classId) {
            $class = ClassRoom::findOrFail($classId);
            $students = $class->students()->active()->orderBy('name')->get();

            // Carregar presenças já registradas para esta data
            $existingAttendances = Attendance::forClass($classId)
                ->forDate($date)
                ->get()
                ->keyBy('student_id');
        }

        return view('attendances.mark', compact('classes', 'students', 'existingAttendances', 'classId', 'date'));
    }

    /**
     * Store attendance records (RF03, RF09).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent',
            'attendances.*.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['attendances'] as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $attendanceData['student_id'],
                        'class_id' => $validated['class_id'],
                        'date' => $validated['date'],
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'time' => now()->format('H:i:s'), // RF09: timestamp automático
                        'notes' => $attendanceData['notes'] ?? null,
                        'recorded_by' => auth()->id(),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('attendances.mark', [
                'class_id' => $validated['class_id'],
                'date' => $validated['date']
            ])->with('success', 'Presenças registradas com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao registrar presenças: ' . $e->getMessage());
        }
    }

    /**
     * Show attendance history for a student (RF05).
     */
    public function studentHistory(Student $student)
    {
        $attendances = $student->attendances()
            ->with(['class', 'recordedBy'])
            ->latest('date')
            ->latest('time')
            ->paginate(30);

        // Estatísticas
        $totalAttendances = $student->attendances()->count();
        $totalPresent = $student->attendances()->present()->count();
        $totalAbsent = $student->attendances()->absent()->count();
        $attendanceRate = $totalAttendances > 0
            ? round(($totalPresent / $totalAttendances) * 100, 2)
            : 0;

        return view('attendances.student-history', compact(
            'student',
            'attendances',
            'totalAttendances',
            'totalPresent',
            'totalAbsent',
            'attendanceRate'
        ));
    }

    /**
     * Show attendance report for a class (RF06).
     */
    public function classReport(ClassRoom $class, Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $students = $class->students()->with(['attendances' => function($query) use ($class, $startDate, $endDate) {
            $query->forClass($class->id)
                ->whereBetween('date', [$startDate, $endDate]);
        }])->get();

        // Calcular estatísticas para cada estudante
        $studentsStats = $students->map(function($student) {
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

        return view('attendances.class-report', compact(
            'class',
            'studentsStats',
            'startDate',
            'endDate'
        ));
    }
}
