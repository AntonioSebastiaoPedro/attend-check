@extends('layouts.app')

@section('title', 'Detalhes da Turma')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-0">{{ $class->name }}</h1>
            <p class="text-muted mb-0">Código: <span class="badge badge-light border">{{ $class->code }}</span></p>
        </div>
        <div class="btn-group">
            <a href="{{ route('classes.students', $class) }}" class="btn btn-success shadow-sm">
                 Gerenciar Alunos
            </a>
            <a href="{{ route('classes.edit', $class) }}" class="btn btn-primary shadow-sm mx-1">
                 Editar
            </a>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary shadow-sm">
                 Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações da Turma -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">Informações Gerais</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="small text-muted text-uppercase font-weight-bold mb-1">Professor</p>
                            <p class="h6 mb-0">{{ $class->teacher->name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <p class="small text-muted text-uppercase font-weight-bold mb-1">Status</p>
                            <span class="badge {{ $class->active ? 'badge-success' : 'badge-danger' }} badge-pill px-3">
                                {{ $class->active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <p class="small text-muted text-uppercase font-weight-bold mb-1">Período</p>
                            <p class="h6 mb-0">{{ $class->academic_year }} / {{ $class->semester }}º Sem</p>
                        </div>
                        @if($class->description)
                        <div class="col-12 mt-2">
                            <p class="small text-muted text-uppercase font-weight-bold mb-1">Descrição</p>
                            <div class="p-3 bg-light rounded text-dark">
                                {{ $class->description }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Lista de Estudantes -->
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">Estudantes Matriculados</h5>
                    <span class="badge badge-primary badge-pill">{{ $class->students->count() }} Alunos</span>
                </div>
                
                @if($class->students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-top-0 px-4 py-3">Nome</th>
                                <th class="border-top-0 py-3">Nº Matrícula</th>
                                <th class="border-top-0 py-3 text-right pr-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                            <tr>
                                <td class="px-4 py-2 font-weight-bold text-dark">{{ $student->name }}</td>
                                <td class="py-2 text-muted">{{ $student->registration_number }}</td>
                                <td class="py-2 text-right pr-4">
                                    <span class="badge {{ $student->active ? 'badge-success' : 'badge-danger' }} small">
                                        {{ $student->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="card-body text-center py-5">
                    <p class="text-muted italic mb-0">Nenhum estudante matriculado nesta turma.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Estatísticas Rápidas -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4 bg-primary text-white text-center">
                <div class="card-body">
                    <p class="small text-uppercase mb-1 opacity-75">Estudantes</p>
                    <h2 class="font-weight-bold mb-0">{{ $class->students->count() }}</h2>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mb-4 bg-success text-white text-center">
                <div class="card-body">
                    <p class="small text-uppercase mb-1 opacity-75">Presenças</p>
                    <h2 class="font-weight-bold mb-0">{{ $class->attendances->where('status', 'present')->count() }}</h2>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4 bg-danger text-white text-center">
                <div class="card-body">
                    <p class="small text-uppercase mb-1 opacity-75">Faltas</p>
                    <h2 class="font-weight-bold mb-0">{{ $class->attendances->where('status', 'absent')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
