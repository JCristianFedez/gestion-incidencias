@extends('layouts.app')

@section('tituloPagina', 'Usuarios')


@section('content')

@include('layouts.includes.status')

@include('layouts.includes.notification')

@include('layouts.includes.errors')

{{-- Formulario para registrar usuario --}}
<form action="" method="POST" class="row needs-validation mb-4" novalidate>
    @csrf

    <div class="col-md-12 form-group">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required
            maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un E-mail valido.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un nombre valido.
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" name="password" id="password" class="form-control" value="{{old('password',Str::random(8))}}"
            required minlength="8">
        <div class="invalid-feedback">
            Porfavor introduzca una contraseña valido.
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="validationServer04">Rol</label>
        <select class="custom-select" name="rol">
            <option value="2">Cliente</option>
            <option value="1" selected>Support</option>
            <option value="0">Admin</option>
        </select>
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Registrar Usuario" class="btn btn-primary">
    </div>
</form>

{{-- Tabla de usuarios support registrados --}}
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>E-mail</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->role_name }}</td>
                <td>
                    <a href="/usuario/{{$user->id}}" class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip"
                        data-placement="left">
                        <i class="fas fa-user-edit"></i>
                    </a>
                    <form action="/usuario/{{$user->id}}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
                            data-placement="right">
                            <i class="fas fa-user-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>
</div>
@endsection