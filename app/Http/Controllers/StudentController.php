<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Exibe uma listagem de estudantes.
     */
    public function index(Request $request)
    {
        $students = $this->studentService->getStudents($request->all());

        return view('students.index', compact('students'));
    }

    /**
     * Mostra o formulário para criar um novo estudante.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Armazena um novo estudante no banco de dados.
     */
    public function store(StoreStudentRequest $request)
    {
        $this->studentService->createStudent($request->validated());

        return redirect()->route('students.index')
            ->with('success', 'Estudante cadastrado com sucesso!');
    }

    /**
     * Exibe o estudante especificado.
     */
    public function show(Student $student)
    {
        $student = $this->studentService->loadStudentDetails($student);

        return view('students.show', compact('student'));
    }

    /**
     * Mostra o formulário para editar o estudante especificado.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Atualiza o estudante especificado no banco de dados.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $this->studentService->updateStudent($student, $request->validated());

        return redirect()->route('students.index')
            ->with('success', 'Estudante atualizado com sucesso!');
    }

    /**
     * Remove o estudante especificado do banco de dados.
     */
    public function destroy(Student $student)
    {
        $this->studentService->deleteStudent($student);

        return redirect()->route('students.index')
            ->with('success', 'Estudante removido com sucesso!');
    }
}
