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
        $user = auth()->user();
        $query = Attendance::with(['student', 'class', 'recordedBy']);

        // Se for professor, limita aos dados das suas turmas
        if ($user->isTeacher()) {
            $query->whereIn('class_id', $user->classes->pluck('id'));
        }

        // Filtro por turma
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filtro por estudante (Search string ou ID)
        if ($request->filled('student_search')) {
            $search = $request->student_search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('registration_number', 'ilike', "%{$search}%");
            });
        }

        // Filtro por data específica
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        // Filtro por período
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->latest('time')->paginate(30)->withQueryString();

        // Dados para os campos de seleção do filtro
        $classes = ClassRoom::active()
            ->when($user->isTeacher(), function($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })
            ->orderBy('name')
            ->get();

        return view('attendances.index', compact('attendances', 'classes'));
    }

    /**
     * Show form to mark attendance for a class (RF03).
     */
    public function markAttendance(Request $request)
    {
        $selectedClassId = $request->get('class_id');
        $date = $request->get('date', now()->format('Y-m-d'));

        $classes = ClassRoom::active()
            ->when(auth()->user()->isTeacher(), function($q) {
                $q->forTeacher(auth()->id());
            })
            ->orderBy('name')
            ->get();

        $students = [];
        $existingAttendances = [];

        if ($selectedClassId) {
            $class = ClassRoom::findOrFail($selectedClassId);
            $students = $class->students()->active()->orderBy('name')->get();

            // Carregar presenças já registradas para esta data
            $existingAttendances = Attendance::forClass($selectedClassId)
                ->forDate($date)
                ->get()
                ->keyBy('student_id');
        }

        return view('attendances.mark', compact('classes', 'students', 'existingAttendances', 'selectedClassId', 'date'));
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

    /**
     * Export attendances to CSV.
     */
    public function export(Request $request)
    {
        $user = auth()->user();
        $query = Attendance::with(['student', 'class', 'recordedBy']);

        // Aplicar os mesmos filtros da listagem
        if ($user->isTeacher()) {
            $query->whereIn('class_id', $user->classes->pluck('id'));
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('student_search')) {
            $search = $request->student_search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('registration_number', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->get();

        $fileName = 'presencas_' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Data', 'Estudante', 'Matricula', 'Turma', 'Status', 'Registrado Por'];

        $callback = function() use ($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->date->format('d/m/Y'),
                    $attendance->student->name,
                    $attendance->student->registration_number,
                    $attendance->class->name,
                    $attendance->status == 'present' ? 'Presente' : 'Faltou',
                    $attendance->recordedBy->name ?? 'N/A',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
