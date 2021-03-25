@extends('layouts.app')

@section('tituloPagina', 'Proyectos')

@section('content')

@include('layouts.includes.status')

@include('layouts.includes.notification')

@include('layouts.includes.errors')

<form action="" method="POST" class="row needs-validation mb-4" novalidate>
    @csrf

    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required minlength="5"
            maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un nombre valido.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Descripción</label>
        <input type="text" name="description" id="description" class="form-control" value="{{old('description')}}"
            required minlength="15" maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca una descripción valida.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="start" class="form-label">Fecha de inicio</label>
        <input type="date" name="start" id="start" class="form-control" value="{{old('start', date('Y-m-d'))}}"
            required>
        <div class="invalid-feedback">
            Porfavor introduzca una fecha valida.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Registrar Proyecto" class="btn btn-primary">
    </div>
</form>

<div class="table-responsive">
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
</div>
@endsection