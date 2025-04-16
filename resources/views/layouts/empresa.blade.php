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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/84360baca8.js" crossorigin="anonymous"></script>
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        /* Estilos para el preloader */
        #preloader {
          position: fixed;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #fff;
          z-index: 9999;
        }
    
        /* Animación de spinner */
        .spinner {
          border: 8px solid #f3f3f3;
          border-top: 8px solid #3498db;
          border-radius: 50%;
          width: 60px;
          height: 60px;
          animation: spin 1s linear infinite;
        }
    
        @keyframes spin {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }
      </style>
    
</head>

<body>

    <div id="preloader">
        <div class="spinner"></div>
    </div>
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
                        @auth('empresa')
                            @if (Route::has('login'))
                                <li class="nav-link" id="bienvenido"> <b>Bienvenido: &nbsp; </b>
                                    {{ Auth::guard('empresa')->user()->NomComercial }}</li>
                                <li class="nav-link"> <b>Estado:</b> <span
                                        style="color: #EE5D31">{{ Auth::guard('empresa')->user()->Estado }}</span> </li>
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
                        <li> <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/empresa') active @endif" href="/empresa"><i
                                    class="fa-solid fa-dashboard"></i> <span>Inicio </span> </li></a>
                        <li> <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/reportes') active @endif" href="/reportes"> <i
                                    class="fa-solid fa-chart-simple"></i> <span> Reportes</span> </li></a>
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
                    <div style="padding:10px;">
                        <x-breadcrumb uri="{{ $_SERVER['REQUEST_URI'] }}" />
                    </div>
                    
                    @yield('content')

                </div>
            </div>
        </main>
    </div>
</body>
<script>
    // Cuando la página se haya cargado completamente, ocultamos el preloader
    window.addEventListener('load', function() {
      const preloader = document.getElementById('preloader');
        // Espera 1 segundo antes de ocultar el preloader
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 1000); // 1000 ms = 1 segundo
      
    });
  </script>

</html>
