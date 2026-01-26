@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 font-weight-bold text-dark mb-0">Editar Usuário</h1>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-muted small text-uppercase">Nome Completo *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="font-weight-bold text-muted small text-uppercase">Endereço de E-mail *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="role" class="font-weight-bold text-muted small text-uppercase">Função / Papel *</label>
                            <select id="role" name="role" required class="form-control custom-select @error('role') is-invalid @enderror" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Professor</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @if($user->id === auth()->id())
                                <input type="hidden" name="role" value="{{ $user->role }}">
                                <small class="form-text text-muted italic">Você não pode alterar seu próprio papel administrativo.</small>
                            @endif
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="bg-light p-3 rounded mb-4 border">
                            <p class="font-weight-bold text-dark small text-uppercase mb-2">Alterar Senha</p>
                            <p class="small text-muted mb-3">Deixe em branco se não desejar alterar a senha atual.</p>
                            
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="password" class="small font-weight-bold text-muted">Nova Senha</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="password_confirmation" class="small font-weight-bold text-muted">Confirmar Nova Senha</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-link text-muted mr-3">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                Atualizar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
