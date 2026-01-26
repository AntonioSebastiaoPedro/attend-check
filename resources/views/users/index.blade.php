@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 font-weight-bold text-dark mb-0">Gestão de Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Novo Usuário
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light text-uppercase small font-weight-bold text-muted">
                    <tr>
                        <th class="px-4 py-3 border-top-0">Nome / Email</th>
                        <th class="py-3 border-top-0">Papel (Role)</th>
                        <th class="py-3 border-top-0">Data de Criação</th>
                        <th class="text-right px-4 py-3 border-top-0">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                            <div class="small text-muted">{{ $user->email }}</div>
                        </td>
                        <td class="py-3">
                            <span class="badge {{ $user->role === 'admin' ? 'badge-primary' : 'badge-secondary' }} px-3 py-1">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 text-muted small">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-right px-4 py-3">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info shadow-sm mr-2" title="Editar">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Excluir">
                                        <i class="fas fa-trash mr-1"></i> Excluir
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-5 text-center text-muted">
                            <div class="mb-2"><i class="fas fa-users fa-3x opacity-25"></i></div>
                            Nenhum usuário encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
