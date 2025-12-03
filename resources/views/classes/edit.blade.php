@extends('layouts.app')

@section('title', 'Editar Turma')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Turma</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('classes.update', $class) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nome da Turma *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $class->name) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                >
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="code" class="block text-gray-700 font-semibold mb-2">Código *</label>
                <input
                    type="text"
                    id="code"
                    name="code"
                    value="{{ old('code', $class->code) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror"
                >
                @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Descrição</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                >{{ old('description', $class->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="teacher_id" class="block text-gray-700 font-semibold mb-2">Professor *</label>
                <select
                    id="teacher_id"
                    name="teacher_id"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('teacher_id') border-red-500 @enderror"
                >
                    <option value="">Selecione um professor</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </select>
                @error('teacher_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="academic_year" class="block text-gray-700 font-semibold mb-2">Ano Letivo *</label>
                    <input
                        type="text"
                        id="academic_year"
                        name="academic_year"
                        value="{{ old('academic_year', $class->academic_year) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('academic_year') border-red-500 @enderror"
                    >
                    @error('academic_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="block text-gray-700 font-semibold mb-2">Semestre *</label>
                    <select
                        id="semester"
                        name="semester"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('semester') border-red-500 @enderror"
                    >
                        <option value="1" {{ old('semester', $class->semester) == 1 ? 'selected' : '' }}>1º Semestre</option>
                        <option value="2" {{ old('semester', $class->semester) == 2 ? 'selected' : '' }}>2º Semestre</option>
                    </select>
                    @error('semester')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        name="active"
                        value="1"
                        {{ old('active', $class->active) ? 'checked' : '' }}
                        class="mr-2"
                    >
                    <span class="text-gray-700">Turma ativa</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('classes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Atualizar Turma
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
