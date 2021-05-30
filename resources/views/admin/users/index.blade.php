@extends('layouts.app')

@section('tituloPagina', 'Usuarios')


@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

{{-- @include('layouts.includes.messages.errors') --}}

{{-- Formulario para registrar usuario --}}
<form action="" method="POST" class="row needs-validation mb-4 border-bottom" novalidate>
    @csrf

    <div class="col-md-12 form-group">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{old('email')}}" required maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca un E-mail valido. Cantidad maxima de caracteres 255.
        </span>
        @endif
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca un nombre valido. Cantidad maxima de caracteres 255.
        </span>
        @endif
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password',Str::random(8))}}"
            required minlength="8" maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una contraseña valida. La contraseña debe de tener entre 8 y 255 caracteres.
        </span>
        @endif
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
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

{{-- Tabla de usuarios registrados --}}
<div id="all-users-table">
    @include('admin.users.includes.index-table')
</div>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/admin/users/index.js') }}"></script>
<script src="{{ asset('/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/js/library/sweetalert2-all.min.js') }}"></script>

@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">

@endsection