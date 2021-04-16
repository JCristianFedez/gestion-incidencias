@if ($deleted_at) {{-- Equivale a $project->trashed() --}}
<form action="{{ route('proyecto.restore', $id) }}" method="GET" class="d-inline-block">
    @csrf
    <input type="hidden" data-project-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-success restore-project" title="Restaurar" data-toggle="tooltip"
        data-placement="top" data-action="restore-project">
        <i class="fas fa-trash-restore"></i>
    </button>
</form>
<form action="{{ route('proyecto.force.destroy', $id) }}" method="POST" class="d-inline-block">
    @csrf
    <input type="hidden" data-project-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-danger force-destroy-project" title="Eliminar" data-toggle="tooltip"
        data-placement="top" data-action="force-destroy-project">
        <i class="fas fa-minus-circle"></i>
    </button>
</form>
{{-- 
 <a href="{{ route('proyecto.restore', $id) }}" class="btn btn-sm btn-success" title="Restaurar"
    data-toggle="tooltip" data-placement="left">
    <i class="fas fa-trash-restore"></i>
</a> --}}
@else
<a href="{{ route('proyecto.edit', $id) }}" class="btn btn-sm btn-primary" title="Editar"
    data-toggle="tooltip" data-placement="top">
    <i class="fas fa-edit"></i>
</a>

<form action="{{ route('proyecto.destroy', $id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <input type="hidden" data-project-name="{{$name}}" value="{{$name}}">
    <button type="submit" class="btn btn-sm btn-danger delete-project" title="Dar de baja" data-toggle="tooltip"
        data-placement="top" data-action="delete-project">
        <i class="fas fa-trash"></i>
    </button>
</form>
@endif
