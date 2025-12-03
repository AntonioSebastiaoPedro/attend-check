@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Turmas</h1>
        <a href="{{ route('classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            + Nova Turma
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('classes.index') }}" class="flex gap-4">
            <div class="flex-1">
                <select name="active" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Todos os Status</option>
                    <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Ativas</option>
                    <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inativas</option>
                </select>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="flex-1">
                <select name="teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Todos os Professores</option>
                    @foreach(\App\Models\User::teachers()->get() as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                Filtrar
            </button>
        </form>
    </div>

    <!-- Lista de Turmas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($classes->count() > 0)
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Professor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ano/Semestre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($classes as $class)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $class->code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $class->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $class->teacher->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $class->academic_year }} / {{ $class->semester }}º Sem
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $class->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $class->active ? 'Ativa' : 'Inativa' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('classes.show', $class) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                        <a href="{{ route('classes.edit', $class) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                        <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Deseja realmente remover esta turma?')">
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $classes->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Nenhuma turma encontrada.</p>
            <a href="{{ route('classes.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                Criar a primeira turma
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
