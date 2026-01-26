@extends('layouts.app')

@section('title', 'Histórico de Presenças')

@section('content')
<div class="container pb-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 font-weight-bold mb-0 text-dark">Histórico de Presenças</h1>
            <p class="text-muted">Consulte e filtre os registros de frequência.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('attendances.mark') }}" class="btn btn-primary shadow-sm">
                + Nova Chamada
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.index') }}" class="form-row align-items-end">
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="font-weight-bold small text-muted text-uppercase">Turma</label>
                    <select name="class_id" class="form-control">
                        <option value="">Todas as Turmas</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="font-weight-bold small text-muted text-uppercase">Data</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="font-weight-bold small text-muted text-uppercase">Estudante (Nome/Reg)</label>
                    <input type="text" name="student_search" value="{{ request('student_search') }}" class="form-control" placeholder="Pesquisar...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary btn-block">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-top-0 px-4 py-3 small font-weight-bold text-muted text-uppercase">Data</th>
                        <th class="border-top-0 py-3 small font-weight-bold text-muted text-uppercase">Turma</th>
                        <th class="border-top-0 py-3 small font-weight-bold text-muted text-uppercase">Estudante</th>
                        <th class="border-top-0 py-3 small font-weight-bold text-muted text-uppercase text-center">Status</th>
                        <th class="border-top-0 py-3 small font-weight-bold text-muted text-uppercase">Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-3 align-middle">
                            <div class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</div>
                            <div class="small text-muted">{{ $attendance->time ?? '--:--' }}</div>
                        </td>
                        <td class="py-3 align-middle text-dark">
                            {{ $attendance->class->name }}
                        </td>
                        <td class="py-3 align-middle">
                            <div class="font-weight-bold text-dark">{{ $attendance->student->name }}</div>
                            <div class="small text-muted">{{ $attendance->student->registration_number }}</div>
                        </td>
                        <td class="py-3 align-middle text-center">
                            @if($attendance->status === 'present')
                                <span class="badge badge-pill badge-success px-3">Presente</span>
                            @else
                                <span class="badge badge-pill badge-danger px-3">Falta</span>
                            @endif
                        </td>
                        <td class="py-3 align-middle text-muted small">
                            {{ $attendance->recordedBy->name ?? 'Sistema' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">
                            <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Nenhum registro encontrado para os filtros selecionados.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-center">
                {{ $attendances->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
