@extends('layouts.app')

@section('title', 'Novo Estudante')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 font-weight-bold mb-0 text-dark">Novo Estudante</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('students.index') }}" class="btn btn-link text-muted pr-0">
                &larr; Voltar para lista
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold">Nome Completo *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex: João Silva"
                            >
                            @error('name')
                            <div class="invalid-feedback"></div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="registration_number" class="font-weight-bold">Nº de Matrícula *</label>
                            <input
                                type="text"
                                id="registration_number"
                                name="registration_number"
                                value="{{ old('registration_number') }}"
                                required
                                class="form-control @error('registration_number') is-invalid @enderror"
                                placeholder="Ex: 2025001"
                            >
                            @error('registration_number')
                            <div class="invalid-feedback"></div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="estudante@exemplo.com"
                            >
                            @error('email')
                            <div class="invalid-feedback"></div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="phone" class="font-weight-bold">Telefone</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror"
                                placeholder="(00) 00000-0000"
                            >
                            @error('phone')
                            <div class="invalid-feedback"></div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="birth_date" class="font-weight-bold">Data de Nascimento</label>
                    <input
                        type="date"
                        id="birth_date"
                        name="birth_date"
                        value="{{ old('birth_date') }}"
                        class="form-control @error('birth_date') is-invalid @enderror"
                    >
                    @error('birth_date')
                    <div class="invalid-feedback"></div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="address" class="font-weight-bold">Endereço</label>
                    <textarea
                        id="address"
                        name="address"
                        rows="2"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Rua, Número, Bairro, Cidade..."
                    >{{ old('address') }}</textarea>
                    @error('address')
                    <div class="invalid-feedback"></div>
                    @enderror
                </div>

                <div class="form-group mb-5">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="hidden"
                            name="active"
                            value="0"
                        >
                        <input
                            type="checkbox"
                            name="active"
                            value="1"
                            id="active"
                            {{ old('active', true) ? 'checked' : '' }}
                            class="custom-control-input"
                        >
                        <label class="custom-control-label font-weight-bold" for="active">Estudante Ativo</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('students.index') }}" class="btn btn-light shadow-sm mr-2 px-4">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm px-4">
                        Salvar Estudante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
