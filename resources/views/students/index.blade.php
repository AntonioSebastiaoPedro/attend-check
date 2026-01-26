@extends('layouts.app')

@section('title', 'Lista de Estudantes')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h1 class="h3 font-weight-bold mb-0">Estudantes</h1>
    </div>
    <div class="col-auto">
        <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm">
            Novo Estudante
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <form action="{{ route('students.index') }}" method="GET" class="form-inline">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou matrícula..." class="form-control mr-2 flex-grow-1">
            <select name="active" class="form-control mr-2">
                <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Ativos</option>
                <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inativos</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light text-uppercase">
                <tr>
                    <th class="border-top-0 small font-weight-bold text-muted">Nome</th>
                    <th class="border-top-0 small font-weight-bold text-muted">Matrícula</th>
                    <th class="border-top-0 small font-weight-bold text-muted">Email</th>
                    <th class="border-top-0 small font-weight-bold text-muted">Status</th>
                    <th class="border-top-0 small font-weight-bold text-muted text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td class="vertical-align-middle">{{ $student->name }}</td>
                    <td class="vertical-align-middle">{{ $student->registration_number }}</td>
                    <td class="vertical-align-middle">{{ $student->email ?? 'N/A' }}</td>
                    <td class="vertical-align-middle">
                        <span class="badge badge-pill {{ $student->active ? 'badge-success' : 'badge-danger' }}">
                            {{ $student->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="align-middle text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary mr-1">Ver</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-dark mr-1">Editar</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja remover este estudante?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Nenhum estudante encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white border-top">
        <div class="d-flex justify-content-center">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
