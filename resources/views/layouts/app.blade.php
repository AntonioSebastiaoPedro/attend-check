<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PresenTrack') - Sistema de Gestão de Presenças</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @auth
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold">PresenTrack</a>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-200">Dashboard</a>
                        <a href="{{ route('classes.index') }}" class="hover:text-blue-200">Turmas</a>
                        <a href="{{ route('students.index') }}" class="hover:text-blue-200">Estudantes</a>
                        <a href="{{ route('attendances.mark') }}" class="hover:text-blue-200">Presença</a>
                        <a href="{{ route('attendances.index') }}" class="hover:text-blue-200">Relatórios</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="text-xs bg-blue-500 px-2 py-1 rounded">{{ ucfirst(auth()->user()->role) }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
