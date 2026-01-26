@extends('layouts.app')

@section('title', 'Registro de Chamada')

@section('content')
<div class="container pb-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 font-weight-bold mb-0 text-dark">Registro de Frequência</h1>
            <p class="text-muted">Realize a chamada dos alunos para a data selecionada.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('attendances.mark') }}" method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5 mb-0">
                    <label class="font-weight-bold small text-muted text-uppercase">Turma</label>
                    <select name="class_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Selecione uma turma...</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->code }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-5 mb-0">
                    <label class="font-weight-bold small text-muted text-uppercase">Data</label>
                    <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
                </div>
                <div class="col-md-2 mb-0 mt-3 mt-md-0">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">Carregar</button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedClassId && count($students) > 0)
    <form action="{{ route('attendances.store') }}" method="POST">
        @csrf
        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0 small font-weight-bold text-muted px-4 py-3">Estudante</th>
                            <th class="border-top-0 small font-weight-bold text-muted text-center py-3">Status da Presença</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        <tr>
                            <td class="px-4 py-3 vertical-align-middle" style="vertical-align: middle;">
                                <div class="font-weight-bold text-dark">{{ $student->name }}</div>
                                <div class="small text-muted">{{ $student->registration_number }}</div>
                                <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
                            </td>
                            <td class="vertical-align-middle text-center" style="vertical-align: middle;">
                                @php
                                    $status = isset($existingAttendances[$student->id]) ? $existingAttendances[$student->id]->status : 'present';
                                @endphp
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success btn-sm px-3 {{ $status == 'present' ? 'active' : '' }}">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="present"
                                            {{ $status == 'present' ? 'checked' : '' }} autocomplete="off">
                                        <i class="fas fa-check mr-1"></i> Presente
                                    </label>
                                    <label class="btn btn-outline-danger btn-sm px-3 {{ $status == 'absent' ? 'active' : '' }}">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="absent"
                                            {{ $status == 'absent' ? 'checked' : '' }} autocomplete="off">
                                        <i class="fas fa-times mr-1"></i> Falta
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white p-4 d-flex justify-content-between align-items-center">
                <span class="text-muted small italic">Verifique os dados antes de salvar.</span>
                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm font-weight-bold">
                    Salvar Chamada
                </button>
            </div>
        </div>
    </form>
    @elseif($selectedClassId)
    <div class="alert alert-info border-0 shadow-sm p-4 text-center" role="alert">
        <i class="fas fa-info-circle fa-2x mb-3 text-info"></i>
        <h5 class="font-weight-bold mb-1">Nenhum estudante matriculado</h5>
        <p class="mb-0">Não há alunos registrados nesta turma no momento.</p>
    </div>
    @endif
</div>
@endsection
