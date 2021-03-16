<div class="card border-primary">
    <div class="card-header bg-primary text-white">Menú</div>

    <div class="card-body">
        <ul class="nav nav-pills">
            @if (auth()->check())
                <li class="nav-item">
                    <a href="/home" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="/ver" class="nav-link">Ver incidencias</a>
                </li>
                <li class="nav-item">
                    <a href="/reportar" class="nav-link">Reportar incidencia</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administracion</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/usuarios">Usuarios</a>
                        <a class="dropdown-item" href="/proyectos">Proyecto</a>
                        <a class="dropdown-item" href="/config">Configuracion</a>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a href="/" class="nav-link">Bienvenido</a>
                </li>
                <li class="nav-item">
                    <a href="/instrucciones" class="nav-link">Instrucciones</a>
                </li>
                <li class="nav-item">
                    <a href="/acerca-de" class="nav-link">Créditos</a>
                </li>
            @endif
        </ul>
    </div>
</div>