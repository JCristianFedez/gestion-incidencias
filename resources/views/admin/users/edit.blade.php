@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">{{ __('Dashboard') }}</div>

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
                            <a href="" class="btn btn-sm btn-danger" title="Dar de baja">
                                <i class="fas fa-user-times"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
