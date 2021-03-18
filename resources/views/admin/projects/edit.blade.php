@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">Editar Usuario</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

            
        @if (session("notification"))
        <div class="alert alert-success">
            {{ session("notification") }}
        </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action=""  method="POST" class="row g-3">
            @csrf
            @method("PUT")
            <div class="col-md-12 form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$project->name)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description" class="form-control" value="{{old('description',$project->description)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="start" class="form-label">Fecha de inicio</label>
                <input type="date" name="start" id="start" class="form-control" value="{{old('start',$project->start)}}">
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Guardar Proyecto" class="btn btn-primary">
            </div>
        </form>

        <div class="row">
            <div class="col-md-6">
                <p>Categorías</p>
                <form action="/categorias" method="POST" class="form-inline mb-3">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Añadir" class="btn btn-primary">
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Proyecto</th>
                                <th>Nivel</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Proyecto A</td>
                                <td>N1</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <form action="" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <p>Niveles</p>
                <form action="/niveles" method="POST" class="form-inline mb-3">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Añadir" class="btn btn-primary">
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nivel</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>N1</td>
                                <td>Atención básica</td>
                                <td>
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
