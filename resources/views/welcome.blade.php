<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PresenTrack</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="text-center mb-5">
            <h1 class="display-3 font-weight-bold text-primary">PresenTrack</h1>
            <p class="lead text-muted">Sistema de Gestão de Presenças</p>
        </div>

        <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%;">
            <div class="card-body p-4 text-center">
                @if (Route::has('login'))
                    @auth
                        <p class="mb-4">Você já está autenticado como <strong>{{ auth()->user()->name }}</strong>.</p>
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg btn-block">Acessar Dashboard</a>
                    @else
                        <p class="mb-4">Bem-vindo ao sistema de gestão de presenças. Faça login para continuar.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block mb-3">Entrar no Sistema</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-block">Registrar-se</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <div class="mt-5 text-muted small">
            &copy; {{ date('Y') }} PresenTrack. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
