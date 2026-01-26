@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 font-weight-bold mb-0 text-dark">Turmas</h1>
        </div>
        @can('admin')
        <div class="col-auto">
            <a href="{{ route('classes.create') }}" class="btn btn-primary shadow-sm">
                + Nova Turma
            </a>
        </div>
        @endcan
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('classes.index') }}" class="form-row align-items-end">
                <div class="form-group col-md-4 mb-0">
                    <select name="active" class="form-control">
                        <option value="">Todos os Status</option>
                        <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Ativas</option>
                        <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inativas</option>
                    </select>
                </div>
                @if(auth()->user()->isAdmin())
                <div class="form-group col-md-5 mb-0">
                    <select name="teacher_id" class="form-control">
                        <option value="">Todos os Professores</option>
                        @foreach(\App\Models\User::teachers()->get() as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-3 mb-0">
                    <button type="submit" class="btn btn-secondary btn-block">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Turmas -->
    <div class="card shadow-sm border-0 overflow-hidden">
        @if($classes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light text-uppercase">
                    <tr>
                        <th class="border-top-0 small font-weight-bold text-muted px-4">Código</th>
                        <th class="border-top-0 small font-weight-bold text-muted">Nome</th>
                        <th class="border-top-0 small font-weight-bold text-muted">Professor</th>
                        <th class="border-top-0 small font-weight-bold text-muted">Ano/Semestre</th>
                        <th class="border-top-0 small font-weight-bold text-muted">Status</th>
                        <th class="border-top-0 small font-weight-bold text-muted text-right pr-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                    <tr>
                        <td class="px-4 font-weight-bold text-dark vertical-align-middle" style="vertical-align: middle;">
                            {{ $class->code }}
                        </td>
                        <td class="vertical-align-middle" style="vertical-align: middle;">
                            {{ $class->name }}
                        </td>
                        <td class="vertical-align-middle text-muted" style="vertical-align: middle;">
                            {{ $class->teacher->name }}
                        </td>
                        <td class="vertical-align-middle text-muted" style="vertical-align: middle;">
                            {{ $class->academic_year }} / {{ $class->semester }}º Sem
                        </td>
                        <td class="vertical-align-middle" style="vertical-align: middle;">
                            <span class="badge badge-pill {{ $class->active ? 'badge-success' : 'badge-danger' }}">
                                {{ $class->active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </td>
                        <td class="pr-4 text-right vertical-align-middle" style="vertical-align: middle;">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-primary mr-1">Ver</a>
                                @can('admin')
                                <a href="{{ route('classes.students', $class) }}" class="btn btn-sm btn-outline-success mr-1">Alunos</a>
                                <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-outline-dark mr-1">Editar</a>
                                <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Deseja realmente remover esta turma?')">
                                        Remover
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-center">
                {{ $classes->links() }}
            </div>
        </div>
        @else
        <div class="card-body text-center py-5">
            <p class="text-muted mb-0">Nenhuma turma encontrada.</p>
            @can('admin')
            <a href="{{ route('classes.create') }}" class="btn btn-link mt-2">
                Criar a primeira turma
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>
@endsection
