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

        {{-- Formulario para editar usuario --}}
        <form action=""  method="POST" class="row g-3">
            @csrf
            @method("PUT")
            <div class="col-md-12 form-group">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" readonly class="form-control" value="{{old('email',$user->email)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="password" class="form-label">Contraseña <em>Ingresar solo si se desea modificar</em></label>
                <input type="text" name="password" id="password" class="form-control" value="{{old('password')}}">
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Guardar Usuario" class="btn btn-primary">
            </div>
        </form>

        {{-- Forumlario para agregar asignar proyecto y nivel --}}
        <form action="/proyecto-usuario" method="POST" class="mb-3">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="row">
                <div class="col-md-4 form-group">
                    <select name="project_id" class="form-control" id="select-project">
                        <option value="">Seleccione proyecto</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <select name="level_id" class="form-control" id="select-level">
                        <option value="">Seleccione nivel</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <button class="btn btn-primary">Asignar proyecto</button>
                </div>
            </div>
        </form>

        {{-- Tavla de los poryectos y nivel del usuario --}}
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
                            <form action="/usuario/{{$user->id}}" method="POST" class="d-inline-block">
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
</div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/admin/users/edit.js') }}"></script>
@endsection