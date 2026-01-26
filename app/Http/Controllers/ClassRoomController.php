<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Student;
use App\Http\Requests\ClassRoom\StoreClassRoomRequest;
use App\Http\Requests\ClassRoom\UpdateClassRoomRequest;
use App\Http\Requests\ClassRoom\AttachStudentsRequest;
use App\Services\ClassRoomService;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    protected $classRoomService;

    public function __construct(ClassRoomService $classRoomService)
    {
        $this->classRoomService = $classRoomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $filters['auth_user'] = auth()->user();

        $classes = $this->classRoomService->getClasses($filters);

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
    public function store(StoreClassRoomRequest $request)
    {
        $this->classRoomService->createClass($request->validated());

        return redirect()->route('classes.index')
            ->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $class)
    {
        $class = $this->classRoomService->loadClassDetails($class);

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
    public function update(UpdateClassRoomRequest $request, ClassRoom $class)
    {
        $this->classRoomService->updateClass($class, $request->validated());

        return redirect()->route('classes.index')
            ->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $class)
    {
        $this->classRoomService->deleteClass($class);

        return redirect()->route('classes.index')
            ->with('success', 'Turma removida com sucesso!');
    }

    /**
     * Show form to manage students in a class.
     */
    public function students(ClassRoom $class)
    {
        $class->load('students');
        $availableStudents = $this->classRoomService->getAvailableStudents($class);

        return view('classes.students', compact('class', 'availableStudents'));
    }

    /**
     * Attach students to a class.
     */
    public function attachStudents(AttachStudentsRequest $request, ClassRoom $class)
    {
        $this->classRoomService->attachStudents($class, $request->validated()['students']);

        return redirect()->route('classes.students', $class)
            ->with('success', 'Estudantes adicionados com sucesso!');
    }

    /**
     * Detach a student from a class.
     */
    public function detachStudent(ClassRoom $class, Student $student)
    {
        $this->classRoomService->detachStudent($class, $student->id);

        return redirect()->route('classes.students', $class)
            ->with('success', 'Estudante removido da turma com sucesso!');
    }
}
