@extends('layouts.app')

@section('title', 'Gerenciar Alunos - ' . $class->name)

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-0 font-weight-bold">{{ $class->name }}</h1>
            <p class="text-muted mb-0">Gerenciar alunos matriculados nesta turma</p>
        </div>
        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
             Voltar para turmas
        </a>
    </div>

    <div class="row">
        <!-- Lista de Alunos Matriculados -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 overflow-hidden mb-4">
                <div class="card-header bg-light py-3 border-bottom-0">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">Alunos Matriculados ({{ $class->students->count() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-white text-uppercase small font-weight-bold text-muted">
                            <tr>
                                <th class="px-4 border-top-0">Nome</th>
                                <th class="border-top-0">Matrícula</th>
                                <th class="text-right px-4 border-top-0">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse($class->students as $student)
                            <tr>
                                <td class="px-4 py-3 vertical-align-middle" style="vertical-align: middle;">
                                    <a href="{{ route('students.show', $student) }}" class="font-weight-bold text-primary">
                                        {{ $student->name }}
                                    </a>
                                </td>
                                <td class="py-3 text-muted vertical-align-middle" style="vertical-align: middle;">
                                    {{ $student->registration_number }}
                                </td>
                                <td class="text-right px-4 py-3 vertical-align-middle" style="vertical-align: middle;">
                                    <form action="{{ route('classes.students.detach', [$class, $student]) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente remover este aluno da turma?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-5 text-center text-muted italic">
                                    Nenhum aluno matriculado nesta turma.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Formulário para Adicionar em Massa -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title mb-0 font-weight-bold text-dark">Adicionar Alunos</h5>
                </div>
                <div class="card-body">
                    @if($availableStudents->count() > 0)
                    <form action="{{ route('classes.students.attach', $class) }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted text-uppercase mb-2 d-block">Selecione os alunos abaixo:</label>
                            <div class="border rounded p-2" style="max-height: 400px; overflow-y: auto; background-color: #fcfcfc;">
                                @foreach($availableStudents as $student)
                                <div class="custom-control custom-checkbox p-2 border-bottom last-child-border-0">
                                    <input type="checkbox" name="students[]" value="{{ $student->id }}" class="custom-control-input" id="student_{{ $student->id }}">
                                    <label class="custom-control-label d-block cursor-pointer pl-1" for="student_{{ $student->id }}">
                                        <div class="font-weight-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $student->name }}</div>
                                        <div class="small text-muted">{{ $student->registration_number }}</div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm">
                            Matricular Selecionados
                        </button>
                        <p class="mt-3 small text-muted text-center italic">
                            Somente alunos ativos e que ainda não estão nesta turma são listados.
                        </p>
                    </form>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted italic mb-0">Todos os alunos ativos já estão matriculados nesta turma.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .last-child-border-0:last-child {
        border-bottom: 0 !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection
