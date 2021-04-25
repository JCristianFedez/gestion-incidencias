<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditLevel"
    data-level-id="{{ $id }}" data-level-name="{{ $name }}" data-level-difficulty="{{ $difficulty }}"
    title="Editar" data-toggle-second="tooltip"
    data-placement="top">
    <i class="fas fa-edit"></i>
</button>
<form action="{{ route("nivel.destroy", $id) }}" method="POST" class="d-inline-block"
    data-level-name="{{$name}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger delete-level" title="Eliminar" data-toggle="tooltip"
        data-placement="top" data-action="delete-level">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>