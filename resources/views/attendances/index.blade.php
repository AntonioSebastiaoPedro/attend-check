@extends('layouts.app')

@section('title', 'Histórico de Frequência')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Histórico de Frequência</h1>
    <a href="{{ route('attendances.mark') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Registrar Nova Presença
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form action="{{ route('attendances.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
            <select name="class_id" class="w-full border rounded px-4 py-2">
                <option value="">Todas as turmas</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Data</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border rounded px-4 py-2">
                <option value="">Todos</option>
                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Presente</option>
                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Faltou</option>
            </select>
        </div>
        <div>
            <button type="submit" class="w-full bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Filtrar</button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500">
            <tr>
                <th class="px-6 py-3 text-left">Data</th>
                <th class="px-6 py-3 text-left">Estudante</th>
                <th class="px-6 py-3 text-left">Turma</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Registrado por</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($attendances as $attendance)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="font-medium text-gray-900">{{ $attendance->student->name }}</div>
                    <div class="text-xs text-gray-500">{{ $attendance->student->registration_number }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->class->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $attendance->status == 'present' ? 'Presente' : 'Faltou' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $attendance->recordedBy->name ?? 'N/A' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum registro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
