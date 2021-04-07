<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield("css")
</head>

<body>
    <div id="app">
        {{-- Menu superior --}}
        <header id="header">
            <nav class="navbar navbar-expand-md navbar-dark bg-gradient-primary shadow-sm fixed-top">
                <div class="container">
                    <button id="vertiacalSidebarCollapse" type="button" data-toggle="collapse"
                        class="btn btn-outline-dark shadow-sm mr-4">
                        <span class="navbar-toggler-icon"></span></button>

                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            @auth
                            <form action="" class="form">

                                @if (auth()->user()->selected_project_id)
                                <select id="list-of-projects" class="custom-select">
                                    @foreach (auth()->user()->list_of_projects as $project)
                                    <option value="{{ $project->id }}" @if($project->id ==
                                        auth()->user()->selected_project_id) selected @endif>
                                        {{ $project->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="custom-select">
                                    <option selected>No pertenece a ningun proyecto</option>
                                </select>
                                @endif
                            </form>
                            @endauth
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-1" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item py-1" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main">
            <div class="contenido">
                {{-- Menu izquierdo --}}
                <nav>
                    @include('layouts.includes.menu')
                </nav>


                {{-- Contenido --}}
                <main class="container-fluid">
                    <div class="page-content px-5 pt-3 pb-5" id="content">
                        <h1 class="h2 border-bottom mb-3">@yield('tituloPagina')</h1>
                        @yield('content')
                    </div>
                </main>
            </div>
        </main>

        <footer id="footer">
            @include('layouts.includes.footer')
        </footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- <script src="{{ asset('js/jquery.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('js/bootstrap.js') }}" defer></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>
    @yield("scripts")

</body>

</html>