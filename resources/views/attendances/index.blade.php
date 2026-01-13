@extends('layouts.app')

@section('title', 'Histórico de Frequência')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Histórico de Frequência</h1>
    <div class="flex gap-2">
        <a href="{{ route('attendances.export', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Exportar CSV
        </a>
        <a href="{{ route('attendances.mark') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Registrar Nova Presença
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-100">
    <h2 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider flex items-center">
        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        Filtros Avançados
    </h2>

    <form action="{{ route('attendances.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Buscar Aluno -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Buscar Aluno</label>
                <input type="text" name="student_search" value="{{ request('student_search') }}"
                       placeholder="Nome ou Nº Matrícula"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Turma -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Turma</label>
                <select name="class_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">Todas as Turmas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Data Início -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">De (Data)</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Data Fim -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Até (Data)</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">Todos</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Presente</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Faltou</option>
                </select>
            </div>

            <!-- Botões -->
            <div class="md:col-span-2 lg:col-span-3 flex items-end gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-sm">
                    Aplicar Filtros
                </button>
                <a href="{{ route('attendances.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg font-bold hover:bg-gray-200 transition">
                    Limpar
                </a>
            </div>
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
