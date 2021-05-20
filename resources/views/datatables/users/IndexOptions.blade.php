@if ($deleted_at)
<form action="{{ route('usuario.restore', $id) }}" method="GET" class="d-inline-block">
    @csrf
    <input type="hidden" data-user-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-success restore-user" title="Restaurar" data-toggle="tooltip"
        data-placement="top" data-action="restore-user">
        <i class="fas fa-trash-restore"></i>
    </button>
</form>
<form action="{{ route('usuario.force.destroy', $id) }}" method="POST" class="d-inline-block">
    @csrf
    <input type="hidden" data-user-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-danger force-destroy-user" title="Eliminar" data-toggle="tooltip"
        data-placement="top" data-action="force-destroy-user">
        <i class="fas fa-minus-circle"></i>
    </button>
</form>
@else
<a href="{{ route('usuario.edit', $id) }}" class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip"
    data-placement="top" role="button">
    <i class="fas fa-user-edit"></i>
</a>
<form action="{{ route('usuario.destroy', $id) }}" method="POST" class="d-inline-block not-send">
    @csrf
    @method('DELETE')
    <input type="hidden" data-user-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-warning delete-user" title="Dar de baja" data-placement="top"
        data-action="delete-user" data-toggle="tooltip">
        <i class="fas fa-user-times"></i>
    </button>
</form>
@endif