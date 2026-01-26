@extends('layouts.app')

@section('title', 'Perfil do Estudante')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 font-weight-bold mb-0">Perfil do Estudante</h1>
            <div class="d-flex">
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning shadow-sm mr-2 text-dark font-weight-bold">
                    Editar
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-secondary shadow-sm">
                    Voltar
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Informações Básicas -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center font-weight-bold mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <h2 class="h5 font-weight-bold mb-1">{{ $student->name }}</h2>
                        <p class="text-muted small mb-2">Matrícula: {{ $student->registration_number }}</p>
                        <span class="badge badge-pill {{ $student->active ? 'badge-success' : 'badge-danger' }} px-3">
                            {{ $student->active ? 'Ativo' : 'Inativo' }}
                        </span>

                        <hr class="my-4">

                        <div class="text-left">
                            <div class="mb-3">
                                <label class="small font-weight-bold text-muted text-uppercase mb-0 d-block">Email</label>
                                <span class="text-dark">{{ $student->email ?? 'Não informado' }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="small font-weight-bold text-muted text-uppercase mb-0 d-block">Telefone</label>
                                <span class="text-dark">{{ $student->phone ?? 'Não informado' }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="small font-weight-bold text-muted text-uppercase mb-0 d-block">Nascimento</label>
                                <span class="text-dark">{{ $student->birth_date ? $student->birth_date->format('d/m/Y') : 'Não informado' }}</span>
                            </div>
                            <div>
                                <label class="small font-weight-bold text-muted text-uppercase mb-0 d-block">Endereço</label>
                                <span class="text-dark">{{ $student->address ?? 'Não informado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Turmas e Frequência Recente -->
            <div class="col-md-8">
                <!-- Turmas Matriculadas -->
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h3 class="h6 font-weight-bold mb-0 text-dark text-uppercase">Turmas Matriculadas</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-top-0 px-4 py-2 small font-weight-bold text-muted">Turma</th>
                                    <th class="border-top-0 py-2 small font-weight-bold text-muted">Código</th>
                                    <th class="border-top-0 py-2 small font-weight-bold text-muted">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->classes as $class)
                                <tr>
                                    <td class="px-4 py-3 align-middle">{{ $class->name }}</td>
                                    <td class="py-3 align-middle">{{ $class->code }}</td>
                                    <td class="py-3 align-middle">
                                        <span class="badge badge-pill {{ $class->active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $class->active ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-muted italic small">Não matriculado em nenhuma turma.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Frequência Recente -->
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h3 class="h6 font-weight-bold mb-0 text-dark text-uppercase">Frequência Recente (Últimas 20)</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light text-uppercase">
                                <tr>
                                    <th class="border-top-0 px-4 py-2 small font-weight-bold text-muted">Data</th>
                                    <th class="border-top-0 py-2 small font-weight-bold text-muted">Turma</th>
                                    <th class="border-top-0 py-2 small font-weight-bold text-muted text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-3 align-middle">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 align-middle">{{ $attendance->class->name }}</td>
                                    <td class="py-3 align-middle text-center">
                                        @if($attendance->status == 'present')
                                            <span class="badge badge-pill badge-success px-3">Presente</span>
                                        @else
                                            <span class="badge badge-pill badge-danger px-3">Falta</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-muted italic small">Nenhum registro de frequência encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
