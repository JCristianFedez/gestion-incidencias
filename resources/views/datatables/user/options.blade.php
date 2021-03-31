<a href="{{ route('usuario.edit', $id) }}" class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip"
    data-placement="left">
    <i class="fas fa-user-edit"></i>
</a>
<form action="{{ route('usuario.destroy', $id) }}" method="POST" class="d-inline-block not-send">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle-second="tooltip"
        data-placement="top" data-action="delete-user" data-toggle="modal" data-target="#confirm-delete">
        <i class="fas fa-user-times"></i>
    </button>
</form>