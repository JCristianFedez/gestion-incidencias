<i class="fa fa-filter" aria-hidden="true"></i>

{{-- Filtrar por Email --}}
<div class="mx-3">
    <div class="dropdown">
        <button class="dropdown-toggle btn btn-light" id="dropdown-email" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-toggle-second="tooltip" data-placement="top" title="Filtrar por E-mail">
            E-mail
        </button>

        {{-- Formulario filtrar por email --}}
        <form class="dropdown-menu p-4 form-not-send" aria-labelledby="dropdown-email">
            <div class="form-group">
                <label for="email-filter">E-mail</label>
                <input type="text" name="email-filter" id="email-filter" class="form-control form-filter"
                    aria-describedby="help-email-filter" data-campo="email">
                <small id="help-email-filter" class="text-muted">Introduzca el email a buscar, tambien se puede buscar por
                    una parte del nombre
                </small>
            </div>
            <button class="btn btn-primary btn-block btn-filter" type="button" id="btn-filtro-email" data-campo="email">Buscar</button>
        </form>
    </div>
</div>


{{-- Filtrar por nombre --}}
<div class="mx-3">
    <div class="dropdown">
        <button class="dropdown-toggle btn btn-light" id="dropdown-name" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-toggle-second="tooltip" data-placement="top" title="Filtrar por nomrbe">
            Nombre
        </button>
        
        {{-- Formulario para validar por nombre --}}
        <form class="dropdown-menu p-4 form-not-send" aria-labelledby="dropdown-name">
            <div class="form-group">
                <label for="name-filter">Nombre</label>
                <input type="text" name="name-filter" id="name-filter" class="form-control form-filter"
                    aria-describedby="help-name-filter" data-campo="name">
                <small id="help-name-filter" class="text-muted">Introduzca el nombre a buscar, tambien se puede buscar por
                    una parte del nombre
                </small>
            </div>
            <button class="btn btn-primary btn-block btn-filter" type="button" id="btn-filtro-name" data-campo="name">Buscar</button>
        </form>
    </div>
</div>

{{-- Filtrar por rol --}}
<div class="mx-3">
    <div class="dropdown">
        <button class="dropdown-toggle btn btn-light" id="dropdown-role" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-toggle-second="tooltip" data-placement="top" title="Filtrar por rol">
            Rol
        </button>

        {{-- Formulario filtrar por rol --}}
        <form class="dropdown-menu p-4 form-not-send" aria-labelledby="dropdown-role">
            <div class="form-group">
                <label for="role-filter">Rol</label>
                <select class="form-control form-filter" name="role-filter" id="role-filter" aria-describedby="help-role-filter" data-campo="role">
                    <option value="2">Cliente</option>
                    <option value="1">Soporte</option>
                    <option value="0">Administrador</option>
                </select>
                <small id="help-role-filter" class="text-muted">Seleccione el rol
                </small>
            </div>
            <button class="btn btn-primary btn-block btn-filter" type="button" id="btn-filtro-role" data-campo="role">Buscar</button>
        </form>
    </div>
</div>

{{-- Eliminar Filtro --}}
<div class="mx-3">
    <button class="btn btn-light" id="remove-filter" 
        data-toggle="tooltip" data-placement="top" title="Eliminar Filtro">
        <i class="fa fa-eraser"></i>
    </button>
</div>