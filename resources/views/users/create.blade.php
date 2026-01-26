@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 font-weight-bold text-dark mb-0">Novo Usuário</h1>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-muted small text-uppercase">Nome Completo *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="João Silva">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="font-weight-bold text-muted small text-uppercase">Endereço de E-mail *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror" placeholder="joao@example.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="role" class="font-weight-bold text-muted small text-uppercase">Função / Papel *</label>
                            <select id="role" name="role" required class="form-control custom-select @error('role') is-invalid @enderror">
                                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Professor</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row mb-4">
                            <div class="col-md-6 form-group">
                                <label for="password" class="font-weight-bold text-muted small text-uppercase">Senha *</label>
                                <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation" class="font-weight-bold text-muted small text-uppercase">Confirmar Senha *</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-link text-muted mr-3">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                Criar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
