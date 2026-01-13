@extends('layouts.app')

@section('title', 'Editar Estudante')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Editar Estudante</h1>
        <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
            <span>&larr; Voltar para lista</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nome Completo *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $student->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Ex: João Silva"
                    >
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="registration_number" class="block text-gray-700 font-semibold mb-2">Nº de Matrícula *</label>
                    <input
                        type="text"
                        id="registration_number"
                        name="registration_number"
                        value="{{ old('registration_number', $student->registration_number) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('registration_number') border-red-500 @enderror"
                        placeholder="Ex: 2025001"
                    >
                    @error('registration_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $student->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        placeholder="estudante@exemplo.com"
                    >
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Telefone</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $student->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                        placeholder="(00) 00000-0000"
                    >
                    @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="birth_date" class="block text-gray-700 font-semibold mb-2">Data de Nascimento</label>
                <input
                    type="date"
                    id="birth_date"
                    name="birth_date"
                    value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror"
                >
                @error('birth_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-semibold mb-2">Endereço</label>
                <textarea
                    id="address"
                    name="address"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                    placeholder="Rua, Número, Bairro, Cidade..."
                >{{ old('address', $student->address) }}</textarea>
                @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input
                        type="hidden"
                        name="active"
                        value="0"
                    >
                    <input
                        type="checkbox"
                        name="active"
                        value="1"
                        {{ old('active', $student->active) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                    >
                    <span class="text-gray-700 font-semibold">Estudante Ativo</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('students.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">
                    Atualizar Estudante
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
