<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <!-- Estilos personalizados -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="https://1premia.com.mx/wp-content/uploads/2022/02/cropped-uno_prima_icon-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://1premia.com.mx/wp-content/uploads/2022/02/cropped-uno_prima_icon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://1premia.com.mx/wp-content/uploads/2022/02/cropped-uno_prima_icon-180x180.png" />
    <meta name="msapplication-TileImage" content="https://1premia.com.mx/wp-content/uploads/2022/02/cropped-uno_prima_icon-270x270.png" />
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-danger" href="#">1Premia</a>
        <div class="d-flex ms-auto">
            @auth
                <span class="navbar-text text-white me-3">
                    Bienvenido, {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
@auth
    @if(auth()->user()->isAdmin())
    <ul class="nav nav-pills nav-fill bg-danger">
        <li class="nav-item">
            <a class="nav-link active bg-danger text-white" aria-current="page" href="/usuarios"><i class="bi bi-people-fill"></i> Usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-danger text-white" href="/admin-tiendas"><i class="bi bi-shop-window"></i> Tiendas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-danger text-white" href="/admin-promociones"><i class="bi bi-percent"></i> Promociones</a>
        </li>
    </ul>
    @elseif(auth()->user()->isUser())
    <ul class="nav nav-pills nav-fill bg-danger">
        <li class="nav-item">
            <a class="nav-link active bg-danger text-white" aria-current="page" href="/tienda"><i class="bi bi-stars"></i> Canjear promocion</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-danger text-white" href="/historial-tienda"><i class="bi bi-clock-history"></i> Historial</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-danger text-white" href="/promociones-tienda"><i class="bi bi-percent"></i> Promociones</a>
        </li>
    </ul>
    @endif
@endauth
    <div class="container mt-4">
        @yield('content')
    </div>
    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>