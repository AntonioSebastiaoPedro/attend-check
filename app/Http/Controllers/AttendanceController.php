<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display attendance list with filters.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $filters = $request->all();
        $filters['user'] = $user;

        $attendances = $this->attendanceService->getAttendances($filters);

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
    public function store(StoreAttendanceRequest $request)
    {
        try {
            $this->attendanceService->storeAttendances($request->validated(), auth()->id());

            return redirect()->route('attendances.mark', [
                'class_id' => $request->class_id,
                'date' => $request->date
            ])->with('success', 'Presenças registradas com sucesso!');

        } catch (\Exception $e) {
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

        $stats = $this->attendanceService->getStudentStats($student);

        return view('attendances.student-history', array_merge([
            'student' => $student,
            'attendances' => $attendances,
        ], [
            'totalAttendances' => $stats['total'],
            'totalPresent' => $stats['present'],
            'totalAbsent' => $stats['absent'],
            'attendanceRate' => $stats['rate'],
        ]));
    }

    /**
     * Show attendance report for a class (RF06).
     */
    public function classReport(ClassRoom $class, Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $studentsStats = $this->attendanceService->getClassReportData($class, $startDate, $endDate);

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
        $filters = $request->all();
        $filters['user'] = auth()->user();

        $attendances = $this->attendanceService->getExportData($filters);

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
