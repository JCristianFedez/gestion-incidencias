@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">Usuarios</div>

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

            <div class="col-md-12 form-group">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="text" name="password" id="password" class="form-control" value="{{old('password',Str::random(8))}}">
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Registrar Usuario" class="btn btn-primary">
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>E-mail</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <a href="/usuario/{{$user->id}}" class="btn btn-sm btn-primary" title="Editar">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
