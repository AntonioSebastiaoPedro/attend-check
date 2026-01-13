@extends('layouts.app')

@section('title', 'Alunos da Turma - ' . $class->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $class->name }}</h1>
            <p class="text-gray-500">Gerenciar alunos matriculados nesta turma</p>
        </div>
        <a href="{{ route('classes.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
            <span>&larr; Voltar para turmas</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Lista de Alunos Matriculados -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Alunos Matriculados ({{ $class->students->count() }})</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">Nome</th>
                            <th class="px-6 py-3 text-left">Matrícula</th>
                            <th class="px-6 py-3 text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($class->students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $student->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->registration_number }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('classes.students.detach', [$class, $student]) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente remover este aluno da turma?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold">
                                        Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Nenhum aluno matriculado nesta turma.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulário para Adicionar em Massa -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="font-bold text-gray-700 mb-4">Adicionar Alunos</h3>

                @if($availableStudents->count() > 0)
                <form action="{{ route('classes.students.attach', $class) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selecione os alunos abaixo:</label>
                        <div class="max-h-96 overflow-y-auto border rounded-lg p-2 space-y-2">
                            @foreach($availableStudents as $student)
                            <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded cursor-pointer border-b last:border-0 border-gray-100">
                                <input type="checkbox" name="students[]" value="{{ $student->id }}" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->registration_number }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-md transition duration-150">
                        Matricular Alunos Selecionados
                    </button>
                    <p class="mt-4 text-xs text-gray-400 text-center italic">
                        Dica: Somente alunos ativos e que ainda não estão nesta turma são listados.
                    </p>
                </form>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500 italic">Todos os alunos ativos já estão matriculados nesta turma.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
