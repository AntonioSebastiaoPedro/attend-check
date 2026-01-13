@extends('layouts.app')

@section('title', 'Marcar Presença')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Registro de Frequência</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form action="{{ route('attendances.mark') }}" method="GET" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
            <select name="class_id" class="w-full border rounded px-4 py-2" onchange="this.form.submit()">
                <option value="">Selecione uma turma...</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                    {{ $class->name }} ({{ $class->code }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Data</label>
            <input type="date" name="date" value="{{ $date }}" class="w-full border rounded px-4 py-2" onchange="this.form.submit()">
        </div>
        <button type="submit" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">Carregar</button>
    </form>
</div>

@if($classId && count($students) > 0)
<form action="{{ route('attendances.store') }}" method="POST">
    @csrf
    <input type="hidden" name="class_id" value="{{ $classId }}">
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500">
                <tr>
                    <th class="px-6 py-3 text-left">Estudante</th>
                    <th class="px-6 py-3 text-center">Presença</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($students as $index => $student)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $student->name }}</div>
                        <div class="text-sm text-gray-500">{{ $student->registration_number }}</div>
                        <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center space-x-6">
                            @php
                                $status = isset($existingAttendances[$student->id]) ? $existingAttendances[$student->id]->status : 'present';
                            @endphp
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="present"
                                    {{ $status == 'present' ? 'checked' : '' }}
                                    class="text-green-600 focus:ring-green-500 h-5 w-5">
                                <span class="text-green-700 font-medium">Presente</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="absent"
                                    {{ $status == 'absent' ? 'checked' : '' }}
                                    class="text-red-600 focus:ring-red-500 h-5 w-5">
                                <span class="text-red-700 font-medium">Faltou</span>
                            </label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-6 bg-gray-50 flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 shadow-md">
                Salvar Chamada
            </button>
        </div>
    </div>
</form>
@elseif($classId)
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-700">
                Nenhum estudante matriculado nesta turma.
            </p>
        </div>
    </div>
</div>
@endif
@endsection
