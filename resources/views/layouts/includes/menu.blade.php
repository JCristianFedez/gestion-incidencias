<div class="vertical-nav bg-dark" id="sidebar">
    <div class="py-4 px-3 mb-4 bg-dark">
        <div class="media-body">
            <h4 class="font-weight-white text-muted mb-0">Menú</h4>
        </div>
    </div>

    <p class="text-white font-weight-bold text-uppercase px-3 small pb-4 mb-0">Principal</p>

    <ul class="nav flex-column bg-dark mb-0">
        <li class="nav-item">
            <a href="/home" class="nav-link text-light font-italic bg-dark
            @if(request()->is(" home") || request()->is("incidencia*"))active @endif">
                <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/reportar" class="nav-link text-light font-italic bg-dark
            @if(request()->is("reportar"))active @endif">
                <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
                Reportar
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
                Services
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                Gallery
            </a>
        </li>
    </ul>

    <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Charts</p>

    <ul class="nav flex-column bg-dark mb-0">
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
                Area charts
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
                Bar charts
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
                Pie charts
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-light font-italic">
                <i class="fa fa-line-chart mr-3 text-primary fa-fw"></i>
                Line charts
            </a>
        </li>
    </ul>
</div>