<span data-toggle="modal" data-target="#modalEditProjectRelation">
    <button type="button" class="btn btn-sm btn-primary" title="Editar"
        data-level-id="{{ $level_id }}"
        data-project-id="{{ $project_id }}"
        data-relation=""
        data-placement="left" data-toggle-second="tooltip" value="{{ $id }}">
        <i class="fas fa-edit"></i>
    </button>
</span>
<form action="/proyecto-usuario/{{ $user_id }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
        data-placement="right">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
