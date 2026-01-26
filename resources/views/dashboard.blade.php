@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h2 font-weight-bold text-dark mb-0">
                Bem-vindo, {{ auth()->user()->name }}!
            </h1>
        </div>
        <div class="col-auto">
            <div class="text-muted font-weight-bold">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm border-left border-primary" style="border-left: 4px solid #007bff !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-light text-primary rounded mr-4">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-muted small text-uppercase font-weight-bold mb-0">Total de Alunos</p>
                            <p class="h3 font-weight-bold text-dark mb-0">{{ $totalStudents }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm border-left border-success" style="border-left: 4px solid #28a745 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-light text-success rounded mr-4">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-muted small text-uppercase font-weight-bold mb-0">Minhas Turmas</p>
                            <p class="h3 font-weight-bold text-dark mb-0">{{ $totalClasses }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm border-left border-info" style="border-left: 4px solid #17a2b8 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-light text-info rounded mr-4">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-muted small text-uppercase font-weight-bold mb-0">Taxa de Presença</p>
                            <div class="d-flex align-items-baseline">
                                <p class="h3 font-weight-bold text-dark mb-0">{{ $attendanceRate }}%</p>
                                <span class="ml-2 text-muted small">(esta semana)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
