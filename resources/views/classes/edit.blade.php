@extends('layouts.app')

@section('title', 'Editar Turma')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 font-weight-bold text-dark mb-0">Editar Turma</h1>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('classes.update', $class) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-muted small text-uppercase">Nome da Turma *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $class->name) }}"
                                required
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                            >
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="code" class="font-weight-bold text-muted small text-uppercase">Código *</label>
                            <input
                                type="text"
                                id="code"
                                name="code"
                                value="{{ old('code', $class->code) }}"
                                required
                                class="form-control @error('code') is-invalid @enderror"
                            >
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="font-weight-bold text-muted small text-uppercase">Descrição</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                            >{{ old('description', $class->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="teacher_id" class="font-weight-bold text-muted small text-uppercase">Professor *</label>
                            <select
                                id="teacher_id"
                                name="teacher_id"
                                required
                                class="form-control custom-select @error('teacher_id') is-invalid @enderror"
                            >
                                <option value="">Selecione um professor</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row mb-4">
                            <div class="col-md-6 form-group">
                                <label for="academic_year" class="font-weight-bold text-muted small text-uppercase">Ano Letivo *</label>
                                <input
                                    type="text"
                                    id="academic_year"
                                    name="academic_year"
                                    value="{{ old('academic_year', $class->academic_year) }}"
                                    required
                                    class="form-control @error('academic_year') is-invalid @enderror"
                                >
                                @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="semester" class="font-weight-bold text-muted small text-uppercase">Semestre *</label>
                                <select
                                    id="semester"
                                    name="semester"
                                    required
                                    class="form-control custom-select @error('semester') is-invalid @enderror"
                                >
                                    <option value="1" {{ old('semester', $class->semester) == 1 ? 'selected' : '' }}>1º Semestre</option>
                                    <option value="2" {{ old('semester', $class->semester) == 2 ? 'selected' : '' }}>2º Semestre</option>
                                </select>
                                @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="hidden" name="active" value="0">
                                <input
                                    type="checkbox"
                                    name="active"
                                    id="active"
                                    value="1"
                                    {{ old('active', $class->active) ? 'checked' : '' }}
                                    class="custom-control-input"
                                >
                                <label class="custom-control-label font-weight-bold" for="active">Turma ativa</label>
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('classes.index') }}" class="btn btn-link text-muted mr-3">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                Atualizar Turma
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
