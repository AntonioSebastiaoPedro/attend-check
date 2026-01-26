@extends('layouts.app')

@section('title', 'Registro de Presença')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-0">Registro de Presença</h1>
            <p class="text-muted mb-0">Selecione uma turma para registrar as presenças do dia</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        @forelse($classes as $class)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100 hover-shadow transition">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge badge-primary px-3 py-1">{{ $class->code }}</span>
                        <div class="text-muted small">
                            <i class="far fa-user"></i> {{ $class->students_count ?? $class->students->count() }} Alunos
                        </div>
                    </div>
                    
                    <h5 class="card-title font-weight-bold text-dark mb-2">{{ $class->name }}</h5>
                    <p class="card-text text-muted small mb-4 flex-grow-1">
                        {{ \Illuminate\Support\Str::limit($class->description, 100, '...') ?: 'Sem descrição disponível.' }}
                    </p>
                    
                    <div class="border-top pt-3 mt-auto">
                        <a href="{{ route('attendances.create', ['class_id' => $class->id]) }}" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm">
                            Registrar Presença
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3"><i class="fas fa-chalkboard fa-4x opacity-25"></i></div>
            <h4 class="text-muted">Nenhuma turma encontrada</h4>
            <p class="text-muted">Você precisa estar vinculado a turmas ativas para registrar presenças.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection
