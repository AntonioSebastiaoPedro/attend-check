@extends('layouts.app')

@section('title', 'Editar Aluno - ' . $student->name)

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-0">Editar Aluno</h1>
            <p class="text-muted mb-0">Atualize as informações de {{ $student->name }}</p>
        </div>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
            Voltar para lista
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold text-dark small text-uppercase">Nome Completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="registration_number" class="font-weight-bold text-dark small text-uppercase">Nº de Matrícula</label>
                            <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', $student->registration_number) }}" class="form-control @error('registration_number') is-invalid @enderror" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="date_of_birth" class="font-weight-bold text-dark small text-uppercase">Data de Nascimento</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" class="form-control @error('date_of_birth') is-invalid @enderror" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="font-weight-bold text-dark small text-uppercase">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                                <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm">
                        Atualizar Aluno
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-link text-muted ml-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
