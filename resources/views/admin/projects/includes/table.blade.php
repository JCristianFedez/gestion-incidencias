<table class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de inicio</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($projects as $project)
        <tr>
            <td>{{ $project->name }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $project->start }}</td>
            <td>

                @if ($project->trashed())
                <a href="/proyecto/{{$project->id}}/restaurar" class="btn btn-sm btn-success" title="Restaurar"
                    data-toggle="tooltip" data-placement="left">
                    <i class="fas fa-trash-restore"></i>
                </a>
                @else
                <a href="/proyecto/{{$project->id}}" class="btn btn-sm btn-primary" title="Editar"
                    data-toggle="tooltip" data-placement="left">
                    <i class="fas fa-edit"></i>
                </a>

                <form action="/proyecto/{{$project->id}}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
                        data-placement="right">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Pagination --}}
<div class="d-flex justify-content-center" id="paginacionProyectos">
    {!! $projects->links() !!}
</div>