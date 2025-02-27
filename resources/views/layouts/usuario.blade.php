<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/84360baca8.js" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/Recurso 2.svg" alt="" srcset="" width="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @auth('web')
                            @if (Route::has('login'))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::guard('web')->user()->Nombre }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <form id="logout-form" action="{{ route('apiLogout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                        <a class="nav-link" href="{{ route('apiLogout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>
                                    </ul>
                                </li>
                            @endif
                        @else
                            <p>No estás autenticado.</p>
                        @endauth


                    </ul>
                </div>
            </div>
        </nav>

        <main class="" style="background-color:#f0f3f4;width: 100%; height: 100%;">
            <div class="row" style="width: 100%; height: 100%;">
                <div class="col-2 sidebar">

                    <ul>
                        <li> <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/usuario') active @endif"
                                href="{{ route('usuario') }}"><i class="fa-solid fa-users"></i> &nbsp; <span>Ver
                                    empresas y usuarios </span> </li></a>
                        <li> <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/nuevaempresa') active @endif"
                                href="{{ route('nuevaemp') }}"> <i class="fa-solid fa-building"></i> &nbsp; <span> crear
                                    Empresa</span> </li></a>
                        @if (Auth::guard('web')->user()->Admin)
                            <li>
                                <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/nuevousuario') active @endif"
                                    href="{{ route('nuevousu') }}"> <i class="fa-solid fa-user-plus"></i> &nbsp;<span>
                                        crear Usuario</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <form id="logout-form" action="{{ route('apiLogout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                            <a class="nav-link" href="{{ route('apiLogout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> <span> Salir</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-10">
                    @yield('content')

                </div>
            </div>
        </main>
    </div>
</body>

</html>
