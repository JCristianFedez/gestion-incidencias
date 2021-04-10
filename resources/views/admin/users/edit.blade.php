@extends('layouts.app')

@section('tituloPagina', 'Editar Usuario')


@section('content')

@include('layouts.includes.status')

@include('layouts.includes.notification')

@include('layouts.includes.errors')

{{-- Formulario para editar usuario --}}
<form action="" method="POST" class="row g-3 needs-validation mb-4" novalidate>
    @csrf
    @method("PUT")
    <div class="col-md-12 form-group">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" id="email" readonly class="form-control" value="{{old('email',$user->email)}}">
    </div>

    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}" required
            maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un nombre valido.
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="password" class="form-label">Contraseña <em>Ingresar solo si se desea modificar</em></label>
        <input type="text" name="password" id="password" class="form-control" value="{{old('password')}}" minlength="8"
            maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca una contraseña valido.
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="validationServer04">Rol</label>
        <select class="custom-select" name="rol">
            <option value="0" @if($user->role == 0) selected @endif>Admin</option>
            <option value="1" @if($user->role == 1) selected @endif>Support</option>
            <option value="2" @if($user->role == 2) selected @endif>Cliente</option>
        </select>
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Guardar cambios" class="btn btn-primary">
    </div>
</form>

@if ($user->is_support)
{{-- Forumlario para agregar asignar proyecto y nivel --}}
<form action="/proyecto-usuario" method="POST" class="mb-3 row needs-validation border-top pt-4 border-secondary" novalidate>
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <div class="col-md-5 form-group">
        <select name="project_id" class="form-control" id="select-project" aria-describedby="select-project-Feedback"
            required>
            <option selected disabled value="">Seleccione proyecto</option>
            @foreach ($projects as $project)
            <option value="{{ $project->id }}">
                {{ $project->name }}
            </option>
            @endforeach
        </select>
        <div id="select-project-Feedback" class="invalid-feedback">
            Ingrese proyecto valido.
        </div>
    </div>
    <div class="col-md-5 form-group">
        <select name="level_id" class="form-control" id="select-level" aria-describedby="select-level-Feedback"
            required>
            <option selected disabled value="">Seleccione nivel</option>
        </select>
        <div id="select-level-Feedback" class="invalid-feedback">
            Ingrese nivel valido.
        </div>
    </div>
    <div class="col-md-2 form-group">
        <button class="btn btn-primary">Asignar proyecto</button>
    </div>
</form>

{{-- Tavla de los poryectos y nivel del usuario --}}
<div id="all-proyects-user-table">
    @include('admin.users.includes.edit-table')
</div>
{{-- <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Proyecto</th>
                <th>Nivel</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects_user as $project_user)
            <tr>
                <td>{{ $project_user->project->name }}</td>
                <td>{{ $project_user->level->name }}</td>
                <td>
                    <span data-toggle="modal" data-target="#modalEditProjectRelation">
                        <button type="button" class="btn btn-sm btn-primary" title="Editar"
                            data-level-id="{{ $project_user->level->id }}"
                            data-project-id="{{ $project_user->project->id }}"
                            data-project-name="{{ $project_user->project->name }}" data-relation=""
                            data-placement="left" data-toggle-second="tooltip" value="{{ $project_user->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </span>
                    <form action="/proyecto-usuario/{{ $project_user->id }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
                            data-placement="right">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
@endif
@endsection

<!-- Modal editar relacion entre usuario y proyecto -->
<div class="modal fade" id="modalEditProjectRelation" tabindex="-1" aria-labelledby="EditProjectRelationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditProjectRelationModalLabel">Editar Relacion con </h5>
                <button type="button" class="close text-black-50" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/proyecto-usuario" method="POST" class="needs-validation" novalidate>
                <div class="modal-body row">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="project_id" value="" id="project_id_relation">
                    <input type="hidden" name="project_user_id" value="" id="project_user_id_relation">
                    <div class="col-12 form-group">
                        <label for="level_id" class="form-label">Seleccione nivel</label>
                        <select name="level_id" class="form-control" id="select_level_relation"
                            aria-describedby="select-level-Feedback" required>
                        </select>
                        <div id="select-level-Feedback" class="invalid-feedback">
                            Ingrese nivel valido.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('scripts')
<script src="{{ asset('/js/admin/users/edit.js') }}"></script>
<script src="{{ asset('/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/js/library/sweetalert2-all.min.js') }}"></script>
@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">

@endsection