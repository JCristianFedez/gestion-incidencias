<nav class="navbar navbar-light navbar-expand-lg bg-gradient-light shadow flex-lg-column">
        <span class="navbar-brand text-center mx-auto rounded">Indice</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#index"
                aria-controls="index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav nav-pills flex-column collapse navbar-collapse" id="index">
                <li class="nav-item"><a class="nav-link" href="#introduction">Introducción</a></li>
                
                {{-- Usuarios --}}
                <li class="nav-item dropdown rounded">
                        <a class="nav-link dropdown-toggle rounded" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Usuarios</a>
                        <div class="dropdown-menu rounded">
                                <a class="dropdown-item rounded" href="#see-users">Ver</a>
                                <a class="dropdown-item rounded" href="#create-user">Crear</a>
                                <a class="dropdown-item rounded" href="#edit-user">Modificar</a>
                                <a class="dropdown-item rounded" href="#delete-user">Eliminar</a>
                        </div>
                </li>

                {{-- Proyectos --}}
                <li class="nav-item dropdown rounded">
                        <a class="nav-link dropdown-toggle rounded" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Proyectos</a>
                        <div class="dropdown-menu rounded">
                                <a class="dropdown-item rounded" href="#see-projects">Ver</a>
                                <a class="dropdown-item rounded" href="#create-project">Crear</a>
                                <a class="dropdown-item rounded" href="#edit-project">Modificar</a>
                                <a class="dropdown-item rounded" href="#delete-project">Eliminar</a>
                                <a class="dropdown-item rounded" href="#change-project">Cambiar</a>
                        </div>
                </li>

                {{-- Incidencias --}}
                <li class="nav-item dropdown rounded">
                        <a class="nav-link dropdown-toggle rounded" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Incidencias</a>
                        <div class="dropdown-menu rounded">
                                <a class="dropdown-item rounded" href="#see-incidents">Ver</a>
                                <a class="dropdown-item rounded" href="#create-incident">Crear</a>
                                <a class="dropdown-item rounded" href="#edit-incident">Modificar</a>
                                <a class="dropdown-item rounded" href="#take-incident">Atender</a>
                                <a class="dropdown-item rounded" href="#disregard-incident">Desatender</a>
                                <a class="dropdown-item rounded" href="#solve-incident">Marcar como resuelta</a>
                                <a class="dropdown-item rounded" href="#open-incident">Volver a abrir</a>
                                <a class="dropdown-item rounded" href="#nextlevel-incident">Derivar al siguiente nivel</a>
                        </div>
                </li>

                {{-- Niveles --}}
                <li class="nav-item dropdown rounded">
                        <a class="nav-link dropdown-toggle rounded" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Niveles</a>
                        <div class="dropdown-menu rounded">
                                <a class="dropdown-item rounded" href="#see-levels">Ver</a>
                                <a class="dropdown-item rounded" href="#create-level">Crear</a>
                                <a class="dropdown-item rounded" href="#edit-level">Modificar</a>
                                <a class="dropdown-item rounded" href="#delete-level">Eliminar</a>
                        </div>
                </li>

                {{-- Categorias --}}
                <li class="nav-item dropdown rounded">
                        <a class="nav-link dropdown-toggle rounded" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">Categorias</a>
                        <div class="dropdown-menu rounded">
                                <a class="dropdown-item rounded" href="#see-categories">Ver</a>
                                <a class="dropdown-item rounded" href="#create-category">Crear</a>
                                <a class="dropdown-item rounded" href="#edit-category">Modificar</a>
                                <a class="dropdown-item rounded" href="#delete-category">Eliminar</a>
                                <a class="dropdown-item rounded" href="#change-category">Cambiar</a>
                        </div>
                </li>
        </ul>
</nav>