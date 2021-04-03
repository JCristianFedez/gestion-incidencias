<div class="vertical-nav bg-light" id="sidebar">
    <h4 class="font-weight-bold text-center mb-4 mt-3">Menú</h4>

    <p class="font-weight-bold text-uppercase px-3 small mb-1">Principal</p>

    <ul class="nav nav-pills flex-column mb-3">
        <li class="nav-item">
            <a href="/" class="nav-link font-italic
            @if(request()->is("/")) active text-white @else text-primary bg-light @endif">
                <i class="fa fa-home mr-3 fa-fw"></i>
                Bienvenido
            </a>
        </li>
        @auth
        <li class="nav-item">
            <a href="/home" class="nav-link font-italic 
            @if(request()->is("home") || request()->is("incidencia*")) active text-white @else text-primary bg-light @endif ">
                <i class="fa fa-th-large mr-3 fa-fw"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/reportar" class="nav-link font-italic 
            @if(request()->is("reportar")) active text-white @else text-primary bg-light @endif">
                <i class="fa fa-address-card mr-3 fa-fw"></i>
                Reportar
            </a>
        </li>
        @endauth
    </ul>

    @auth
        @if (auth()->user()->is_admin)
        <p class="font-weight-bold text-uppercase px-3 small mb-1">Admin</p>

        <ul class="nav nav-pills flex-column mb-3">
            <li class="nav-item">
                <a href="/usuarios" class="nav-link font-italic  
                @if(request()->is("usuario*")) active text-white @else text-primary bg-light @endif">
                    <i class="fas fa-users-cog mr-3 fa-fw"></i>
                    Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="/proyectos" class="nav-link font-italic
                @if(request()->is("proyecto*")) active text-white @else text-primary bg-light @endif">
                    <i class="fas fa-project-diagram mr-3 fa-fw"></i>
                    Proyectos
                </a>
            </li>
        </ul>
        @endif
    @endauth

    <p class="font-weight-bold text-uppercase px-3 small mb-1">Informacion</p>

    <ul class="nav nav-pills flex-column mb-0">
        <li class="nav-item">
            <a href="/creditos" class="nav-link font-italic
            @if(request()->is("creditos")) active text-white @else text-primary bg-light @endif">
                <i class="fab fa-gratipay mr-3 fa-fw"></i>
                Creditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/instrucciones" class="nav-link font-italic 
            @if(request()->is("instrucciones")) active text-white @else text-primary bg-light @endif">
                <i class="fas fa-book mr-3 fa-fw"></i>
                Instrucciones
            </a>
        </li>
    </ul>
</div>