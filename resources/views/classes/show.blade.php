@extends('layouts.app')

@section('title', 'Detalhes da Turma')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $class->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('classes.students', $class) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                Gerenciar Alunos
            </a>
            <a href="{{ route('classes.edit', $class) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Editar
            </a>
            <a href="{{ route('classes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                Voltar
            </a>
        </div>
    </div>

    <!-- Informações da Turma -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informações da Turma</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Código</p>
                <p class="text-lg font-medium">{{ $class->code }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-flex px-2 py-1 text-xs leading-5 font-semibold rounded-full
                    {{ $class->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $class->active ? 'Ativa' : 'Inativa' }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Professor</p>
                <p class="text-lg font-medium">{{ $class->teacher->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Período</p>
                <p class="text-lg font-medium">{{ $class->academic_year }} - {{ $class->semester }}º Semestre</p>
            </div>
            @if($class->description)
            <div class="col-span-2">
                <p class="text-sm text-gray-500">Descrição</p>
                <p class="text-gray-700">{{ $class->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Total de Estudantes</p>
            <p class="text-3xl font-bold text-blue-600">{{ $class->students->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Presenças Registradas</p>
            <p class="text-3xl font-bold text-green-600">{{ $class->attendances->where('status', 'present')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Faltas Registradas</p>
            <p class="text-3xl font-bold text-red-600">{{ $class->attendances->where('status', 'absent')->count() }}</p>
        </div>
    </div>

    <!-- Lista de Estudantes -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Estudantes Matriculados</h2>

        @if($class->students->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nº Matrícula</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($class->students as $student)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $student->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $student->registration_number }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $student->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $student->active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Nenhum estudante matriculado nesta turma.</p>
        @endif
    </div>
</div>
@endsection
