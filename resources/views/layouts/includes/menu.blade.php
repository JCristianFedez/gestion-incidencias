<div class="card border-primary">
    <div class="card-header bg-primary text-white">Menú</div>

    <div class="card-body">
        <ul class="nav nav-pills">
            @if (auth()->check())
                <li class="nav-item">
                    <a href="" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Ver incidencias</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Reportar incidencia</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Administracion</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="" class="nav-link">Bienvenido</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Instrucciones</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Créditos</a>
                </li>
            @endif
        </ul>
    </div>
</div>