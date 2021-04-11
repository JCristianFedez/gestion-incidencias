<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditCategory" title="Editar"
    data-category-id="{{ $id }}" data-category-name="{{ $name }}" data-toggle-second="tooltip"
    data-placement="left">
    <i class="fas fa-edit"></i>
</button>
<form action="{{ route("categoria.destroy", $id) }}" method="POST" class="d-inline-block" data-category-name="{{$name}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger delete-category" title="Dar de baja" data-toggle="tooltip"
        data-placement="right" data-action="delete-category">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>