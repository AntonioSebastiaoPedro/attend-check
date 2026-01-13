<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ClassRoom::with('teacher');

        // Filtrar por status ativo/inativo
        if ($request->has('active')) {
            if ($request->active == '1') {
                $query->active();
            } else {
                $query->where('active', false);
            }
        }

        // Filtrar por professor (se não for admin)
        if (auth()->user()->isTeacher()) {
            $query->forTeacher(auth()->id());
        } elseif ($request->has('teacher_id')) {
            $query->forTeacher($request->teacher_id);
        }

        $classes = $query->orderBy('name')->paginate(15);

        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::teachers()->orderBy('name')->get();
        return view('classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|integer|min:1|max:2',
            'active' => 'boolean',
        ]);

        $class = ClassRoom::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $class)
    {
        $class->load(['teacher', 'students', 'attendances' => function($query) {
            $query->latest()->limit(50);
        }]);

        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $class)
    {
        $teachers = User::teachers()->orderBy('name')->get();
        return view('classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes,code,' . $class->id,
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|integer|min:1|max:2',
            'active' => 'boolean',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $class)
    {
        $class->delete(); // Soft delete

        return redirect()->route('classes.index')
            ->with('success', 'Turma removida com sucesso!');
    }

    /**
     * Show form to manage students in a class.
     */
    public function students(ClassRoom $class)
    {
        $class->load('students');
        $availableStudents = Student::active()
            ->whereNotIn('id', $class->students->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('classes.students', compact('class', 'availableStudents'));
    }

    /**
     * Attach students to a class.
     */
    public function attachStudents(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $class->students()->attach($validated['students']);

        return redirect()->route('classes.students', $class)
            ->with('success', 'Estudantes adicionados com sucesso!');
    }

    /**
     * Detach a student from a class.
     */
    public function detachStudent(ClassRoom $class, Student $student)
    {
        $class->students()->detach($student->id);

        return redirect()->route('classes.students', $class)
            ->with('success', 'Estudante removido da turma com sucesso!');
    }
}
