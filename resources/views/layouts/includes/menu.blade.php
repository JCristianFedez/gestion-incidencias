<div class="card border-primary">
    <div class="card-header bg-primary text-white">Menú</div>

    <div class="card-body">
        <ul class="nav nav-pills">
            @if (auth()->check())
                <li class="nav-item">
                    <a href="/home" class="nav-link @if(request()->is("home"))active @endif">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="/ver" class="nav-link @if(request()->is("ver"))active @endif">Ver incidencias</a>
                </li>
                <li class="nav-item">
                    <a href="/reportar" class="nav-link @if(request()->is("reportar"))active @endif">Reportar incidencia</a>
                </li>
                @if (auth()->user()->is_admin)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administracion</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/usuarios">Usuarios</a>
                            <a class="dropdown-item" href="/proyectos">Proyecto</a>
                            <a class="dropdown-item" href="/config">Configuracion</a>
                        </div>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a href="/" class="nav-link @if(request()->is("/"))active @endif">Bienvenido</a>
                </li>
                <li class="nav-item">
                    <a href="/instrucciones" class="nav-link @if(request()->is("instrucciones"))active @endif">Instrucciones</a>
                </li>
                <li class="nav-item">
                    <a href="/acerca-de" class="nav-link @if(request()->is("acerca-de"))active @endif">Créditos</a>
                </li>
            @endif
        </ul>
    </div>
</div>