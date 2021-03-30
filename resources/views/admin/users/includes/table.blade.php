<div class="table-responsive">
    <button class="btn btn-info d-block w-100 my-3" data-toggle="tooltip" data-placement="top"
        data-clear-filter="users-table" title="Eliminar Filtro">
        <i class="fa fa-eraser"></i>
    </button>
    <table class="table table-striped table-bordered table-hover w-100" id="users-table">

        <thead class="thead-dark">
            <tr>
                <th>E-mail</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Opciones</th>
            </tr>
            <tr>
                <th><input type="text" class="form-control w-100" placeholder="Buscar E-mail" data-toggle="tooltip"
                        data-placement="top" title="Buscar E-mail" /></th>
                <th><input type="text" class="form-control w-100" placeholder="Buscar Nombre" data-toggle="tooltip"
                        data-placement="top" title="Buscar Nombre" /></th>
                <th>
                    <select class="custom-select" data-toggle="tooltip" data-placement="top" title="Seleccionar Rol">
                        <option value="" selected>Seleccionar Rol</option>
                        <option value="Admin">Administrador</option>
                        <option value="Support">Support</option>
                        <option value="Cliente">Cliente</option>
                    </select>
                </th>
                <th>
                    <button class="btn btn-light d-block w-100" data-toggle="tooltip" data-placement="top"
                        data-clear-filter="users-table" title="Eliminar Filtro">
                        <i class="fa fa-eraser"></i>
                    </button>
                </th>
            </tr>
        </thead>
    </table>
</div>