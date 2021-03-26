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

{{-- Formulario de filtrar por nombre --}}
<div class="form-group mb-4">
    <label for="nameFilter">Nombre</label>
    <div class="input-group">
        <input type="text" name="nameFilter" id="nameFilter" class="form-control" aria-describedby="helpNameFilter">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="btn-filtro-nombre">Buscar</button>
        </div>
    </div>
    <small id="helpNameFilter" class="text-muted">Introduzca el nombre a buscar, tambien se puede buscar por 
        una parte del nombre
    </small>
</div>

<div class="table-responsive" id="allProjectsTable">
    @include('admin.projects.includes.table',['projects' => $projects])
</div>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/admin/projects/index.js') }}"></script>
@endsection