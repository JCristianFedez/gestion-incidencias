<span data-toggle="modal" data-target="#modalEditProjectRelation">
    <button type="button" class="btn btn-sm btn-primary" title="Editar"
        data-level-id="{{ $level_id }}"
        data-project-id="{{ $project_id }}"
        data-relation=""
        data-placement="top" data-toggle="tooltip" value="{{ $id }}">
        <i class="fas fa-edit"></i>
    </button>
</span>
<form action="{{ route("proyecto-user.destory",$id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger delete-user-project" title="Eliminar" data-toggle="tooltip"
        data-placement="top" data-action="delete-user-project">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
