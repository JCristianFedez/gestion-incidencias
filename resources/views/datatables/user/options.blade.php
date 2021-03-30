<a href="{{ route('usuario.edit', $id) }}" class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip"
    data-placement="left">
    <i class="fas fa-user-edit"></i>
</a>
<form action="{{ route('usuario.destroy', $id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
        data-placement="right">
        <i class="fas fa-user-times"></i>
    </button>
</form>