@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">Proyectos</div>

    <div class="card-body">
        @include('layouts.includes.status')
        
        @include('layouts.includes.notification')

        @include('layouts.includes.errors')

        <form action=""  method="POST" class="row g-3">
            @csrf

            <div class="col-md-12 form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description" class="form-control" value="{{old('description')}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="start" class="form-label">Fecha de inicio</label>
                <input type="date" name="start" id="start" class="form-control" value="{{old('start', date('Y-m-d'))}}">
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
                                    <a href="/proyecto/{{$project->id}}/restaurar" class="btn btn-sm btn-success" title="Restaurar">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>
                                @else
                                    <a href="/proyecto/{{$project->id}}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="/proyecto/{{$project->id}}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
