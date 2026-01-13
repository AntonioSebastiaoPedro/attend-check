@extends('layouts.app')

@section('title', 'Perfil do Estudante')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Perfil do Estudante</h1>
        <div class="flex gap-2">
            <a href="{{ route('students.edit', $student) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('students.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informações Básicas -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center mb-4">
                    <div class="h-24 w-24 bg-blue-100 text-blue-600 rounded-full mx-auto flex items-center justify-center text-3xl font-bold mb-2">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold">{{ $student->name }}</h2>
                    <p class="text-gray-500 text-sm">Matrícula: {{ $student->registration_number }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full {{ $student->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $student->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <div class="border-t pt-4 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                        <p class="text-sm truncate">{{ $student->email ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Telefone</p>
                        <p class="text-sm">{{ $student->phone ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Nascimento</p>
                        <p class="text-sm">{{ $student->birth_date ? $student->birth_date->format('d/m/Y') : 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Endereço</p>
                        <p class="text-sm">{{ $student->address ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Turmas e Frequência Recente -->
        <div class="md:col-span-2 space-y-6">
            <!-- Turmas Matriculadas -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Turmas Matriculadas</h3>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-6 py-2">Turma</th>
                            <th class="px-6 py-2">Código</th>
                            <th class="px-6 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($student->classes as $class)
                        <tr>
                            <td class="px-6 py-3">{{ $class->name }}</td>
                            <td class="px-6 py-3">{{ $class->code }}</td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 text-xs rounded {{ $class->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $class->active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Não matriculado em nenhuma turma.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Frequência Recente -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Frequência Recente (Últimas 20)</h3>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-6 py-2">Data</th>
                            <th class="px-6 py-2">Turma</th>
                            <th class="px-6 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($student->attendances as $attendance)
                        <tr>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">{{ $attendance->class->name }}</td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 text-xs rounded-full {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $attendance->status == 'present' ? 'Presente' : 'Faltou' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Nenhum registro de frequência encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
