@extends('layouts.app')

@section('title', 'Marcar Presença')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3 font-weight-bold mb-0 text-dark">Registro de Frequência</h1>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('attendances.mark') }}" method="GET" class="form-row align-items-end">
            <div class="form-group col-md-5 mb-0">
                <label class="font-weight-bold small text-muted text-uppercase">Turma</label>
                <select name="class_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Selecione uma turma...</option>
                    @foreach( as )
                    <option value="{{ ->id }}" {{  == ->id ? 'selected' : '' }}>
                        {{ ->name }} ({{ ->code }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-5 mb-0">
                <label class="font-weight-bold small text-muted text-uppercase">Data</label>
                <input type="date" name="date" value="{{  }}" class="form-control" onchange="this.form.submit()">
            </div>
            <div class="col-md-2 mb-0">
                <button type="submit" class="btn btn-secondary btn-block">Carregar</button>
            </div>
        </form>
    </div>
</div>

@if( && count() > 0)
<form action="{{ route('attendances.store') }}" method="POST">
    @csrf
    <input type="hidden" name="class_id" value="{{  }}">
    <input type="hidden" name="date" value="{{  }}">

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light text-uppercase">
                    <tr>
                        <th class="border-top-0 small font-weight-bold text-muted px-4">Estudante</th>
                        <th class="border-top-0 small font-weight-bold text-muted text-center">Presença</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( as  => )
                    <tr>
                        <td class="px-4 vertical-align-middle" style="vertical-align: middle;">
                            <div class="font-weight-bold text-dark">{{ ->name }}</div>
                            <div class="small text-muted">{{ ->registration_number }}</div>
                            <input type="hidden" name="attendances[{{  }}][student_id]" value="{{ ->id }}">
                        </td>
                        <td class="vertical-align-middle text-center" style="vertical-align: middle;">
                            @php
                                 = isset([->id]) ? [->id]->status : 'present';
                            @endphp
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-success btn-sm {{  == 'present' ? 'active' : '' }}">
                                    <input type="radio" name="attendances[{{  }}][status]" value="present"
                                        {{  == 'present' ? 'checked' : '' }} autocomplete="off">
                                    Presente
                                </label>
                                <label class="btn btn-outline-danger btn-sm {{  == 'absent' ? 'active' : '' }}">
                                    <input type="radio" name="attendances[{{  }}][status]" value="absent"
                                        {{  == 'absent' ? 'checked' : '' }} autocomplete="off">
                                    Faltou
                                </label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-light p-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm font-weight-bold">
                Salvar Chamada
            </button>
        </div>
    </div>
</form>
@elseif()
<div class="alert alert-warning border-0 shadow-sm" role="alert">
    <div class="d-flex align-items-center">
        <svg class="mr-3" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        <span class="font-weight-bold">Nenhum estudante matriculado nesta turma.</span>
    </div>
</div>
@endif
@endsection
