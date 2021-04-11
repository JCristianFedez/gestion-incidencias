<div class="modal fade" id="modalEditLevel" tabindex="-1" aria-labelledby="EditLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditLevelModalLabel">Editar Nivel</h5>
                <button type="button" class="close text-black-50" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route("nivel.update") }}" method="POST" class="needs-validation" novalidate
            data-level-name="">
                <div class="modal-body row">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="level_id" id="level_id" value="">
                    <div class="form-group col-12">
                        <label for="name">Nombre del nivel</label>
                        <input type="text" name="name" id="level_name" class="form-control" value="" required
                            minlength="5" maxlength="15">
                        <div class="invalid-feedback">
                            Porfavor introduzca un nombre valido.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="update-level">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>