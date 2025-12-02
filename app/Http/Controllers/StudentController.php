<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Aplicar busca se fornecida (RF08)
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filtrar por status ativo/inativo
        if ($request->has('active')) {
            if ($request->active == '1') {
                $query->active();
            } else {
                $query->where('active', false);
            }
        }

        $students = $query->orderBy('name')->paginate(15);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:50|unique:students',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $student = Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Estudante cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // Carregar turmas e presenças
        $student->load(['classes', 'attendances' => function($query) {
            $query->latest()->limit(20);
        }]);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:50|unique:students,registration_number,' . $student->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Estudante atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete(); // Soft delete

        return redirect()->route('students.index')
            ->with('success', 'Estudante removido com sucesso!');
    }
}
