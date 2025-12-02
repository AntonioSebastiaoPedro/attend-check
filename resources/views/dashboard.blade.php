@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            Bem-vindo, {{ auth()->user()->name }}!
        </h1>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-blue-700">
                <strong>Perfil:</strong> {{ ucfirst(auth()->user()->role) }}
            </p>
            <p class="text-blue-700">
                <strong>Email:</strong> {{ auth()->user()->email }}
            </p>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Sistema de Gestão de Presenças</h2>
            <p class="text-gray-600">
                O PresenTrack está pronto para uso. Em breve, mais funcionalidades serão adicionadas.
            </p>
        </div>
    </div>
</div>
@endsection
