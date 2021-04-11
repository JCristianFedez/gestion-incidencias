<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="EditCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditCategoryModalLabel">Editar Categoría</h5>
                <button type="button" class="close text-black-50" data-dismiss="modal" aria-label="Close"
                    aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route("categoria.update") }}" method="POST" class="needs-validation" novalidate
            data-category-name="">
                <div class="modal-body row">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="category_id" id="category_id" value="">
                    <div class="form-group col-12">
                        <label for="name">Nombre de la categoría</label>
                        <input type="text" name="name" id="category_name" class="form-control" value="" required
                            minlength="5" maxlength="255">
                        <div class="invalid-feedback">
                            Porfavor introduzca un nombre valido.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="update-category">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>