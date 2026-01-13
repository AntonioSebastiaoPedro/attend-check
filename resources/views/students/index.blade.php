@extends('layouts.app')

@section('title', 'Lista de Estudantes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Estudantes</h1>
    <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Novo Estudante
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <form action="{{ route('students.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou matrícula..." class="border rounded px-4 py-2 flex-grow">
            <select name="active" class="border rounded px-4 py-2">
                <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Ativos</option>
                <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inativos</option>
            </select>
            <button type="submit" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Filtrar</button>
        </form>
    </div>

    <table class="w-full">
        <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500">
            <tr>
                <th class="px-6 py-3 text-left">Nome</th>
                <th class="px-6 py-3 text-left">Matrícula</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-right">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($students as $student)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $student->registration_number }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $student->email ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $student->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $student->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2 flex justify-end items-center">
                    <a href="{{ route('students.show', $student) }}" class="text-blue-600 hover:underline">Ver</a>
                    <a href="{{ route('students.edit', $student) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover este estudante?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum estudante encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $students->links() }}
    </div>
</div>
@endsection
