<div class="vertical-nav bg-dark" id="sidebar">
    <h4 class="font-weight-bold text-primary text-center my-4">Menú</h4>

    <p class="text-white font-weight-bold text-uppercase px-3 small mb-1">Principal</p>

    <ul class="nav nav-pills flex-column bg-dark mb-3">
        <li class="nav-item">
            <a href="/" class="nav-link text-light font-italic
            @if(request()->is("/")) active @else bg-dark @endif">
                <i class="fa fa-home mr-3 fa-fw
                @if(! request()->is("/")) text-primary @endif"></i>
                Bienvenido
            </a>
        </li>
        @auth
        <li class="nav-item">
            <a href="/home" class="nav-link text-light font-italic 
            @if(request()->is("home") || request()->is("incidencia*")) active @else bg-dark @endif ">
                <i class="fa fa-th-large mr-3 fa-fw
                @if(! (request()->is("home") || request()->is("incidencia*"))) text-primary @endif"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/reportar" class="nav-link text-light font-italic 
            @if(request()->is("reportar")) active @else bg-dark @endif">
                <i class="fa fa-address-card mr-3 fa-fw
                @if(! request()->is("reportar")) text-primary @endif"></i>
                Reportar
            </a>
        </li>
        @endauth
    </ul>

    @auth
        @if (auth()->user()->is_admin)
        <p class="text-white font-weight-bold text-uppercase px-3 small mb-1">Admin</p>

        <ul class="nav flex-column bg-dark mb-3">
            <li class="nav-item">
                <a href="/usuarios" class="nav-link text-light font-italic  
                @if(request()->is("usuario*")) active @else bg-dark @endif">
                    <i class="fas fa-users-cog mr-3 fa-fw
                    @if(! request()->is("usuario*")) text-primary @endif"></i>
                    Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="/proyectos" class="nav-link text-light font-italic
                @if(request()->is("proyecto*")) active @else bg-dark @endif">
                    <i class="fas fa-project-diagram mr-3 fa-fw
                    @if(! request()->is("proyecto*")) text-primary @endif"></i>
                    Proyectos
                </a>
            </li>
        </ul>
        @endif
    @endauth

    <p class="text-white font-weight-bold text-uppercase px-3 small mb-1">Informacion</p>

    <ul class="nav flex-column bg-dark mb-0">
        <li class="nav-item">
            <a href="/creditos" class="nav-link text-light font-italic
            @if(request()->is("creditos")) active @else bg-dark @endif">
                <i class="fab fa-gratipay mr-3 fa-fw
                @if(! request()->is("creditos")) text-primary @endif"></i>
                Creditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/instrucciones" class="nav-link text-light font-italic 
            @if(request()->is("instrucciones")) active @else bg-dark @endif">
                <i class="fas fa-book mr-3 fa-fw
                @if(! request()->is("instrucciones")) text-primary @endif"></i>
                Instrucciones
            </a>
        </li>
    </ul>
</div>