@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-5">
                    <h1 class="h2 font-weight-bold text-primary">PresenTrack</h1>
                    <p class="text-muted">Sistema de Gestão de Presenças</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="email" class="font-weight-bold">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="seu@email.com"
                        >
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="font-weight-bold">
                            Senha
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                            <label class="custom-control-label text-muted" for="remember">Lembrar-me</label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-block font-weight-bold"
                    >
                        Entrar
                    </button>
                </form>

                <div class="mt-4 text-center text-muted small">
                    <p class="mb-0">Acesso exclusivo para Administradores e Professores</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
