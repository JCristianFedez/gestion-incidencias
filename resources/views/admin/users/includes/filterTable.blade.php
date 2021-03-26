<i class="fa fa-filter" aria-hidden="true"></i>

{{-- Filtrar por Email --}}
<div class="mx-3">
    <div class="dropdown">
        <button class="dropdown-toggle btn btn-light" id="dropdownEmail" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-toggle-second="tooltip" data-placement="top" title="Filtrar por E-mail">
            E-mail
        </button>
        <form class="dropdown-menu p-4" aria-labelledby="dropdownEmail">
            <div class="form-group">
                <label for="emailFilter">E-mail</label>
                <input type="text" name="emailFilter" id="emailFilter" class="form-control"
                    aria-describedby="helpEmailFilter">
                <small id="helpEmailFilter" class="text-muted">Introduzca el email a buscar, tambien se puede buscar por
                    una parte del nombre
                </small>
            </div>
            <button class="btn btn-primary btn-block" type="button" id="btn-filtro-email">Buscar</button>
        </form>
    </div>
</div>


{{-- Filtrar por nombre --}}
<div class="mx-3">
    <div class="dropdown">
        <button class="dropdown-toggle btn btn-light" id="dropdownNombre" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" data-toggle-second="tooltip" data-placement="top" title="Filtrar por nomrbe">
            Nombre
        </button>
        <form class="dropdown-menu p-4" aria-labelledby="dropdownNombre">
            <div class="form-group">
                <label for="nameFilter">Nombre</label>
                <input type="text" name="nameFilter" id="nameFilter" class="form-control"
                    aria-describedby="helpNameFilter">
                <small id="helpNameFilter" class="text-muted">Introduzca el nombre a buscar, tambien se puede buscar por
                    una parte del nombre
                </small>
            </div>
            <button class="btn btn-primary btn-block" type="button" id="btn-filtro-nombre">Buscar</button>
        </form>
    </div>
</div>

{{-- Eliminar Filtro --}}
<div class="mx-3">
    <button class="btn btn-light" id="removeFilter" 
        data-toggle="tooltip" data-placement="top" title="Eliminar Filtro">
        <i class="fa fa-eraser"></i>
    </button>
</div>